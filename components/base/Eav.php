<?php
namespace app\components\base;

use app\models\PortfolioProperty;
use Yii;
use yii\base\Component;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class Eav extends Component {
    public $item_class;
    public $item_value_class;
    public $property_class;
    public $property_value_class;

    public $item_id = 'item_id';
    public $item_uniq_id = 'ivt.[item_id]';
    public $property_id = 'property_id';
    public $value_id = 'value_id';
    public $value_enum = 'value_id';
    public $value_boolean = 'value_id';

    public $item_table;
    public $item_value_table;
    public $property_table;
    public $property_value_table;

    public $property_types = [
        'object' => 1,
        'number' => 2,
        'boolean' => 3,
    ];

    public $item_criteria;
    public $property_criteria;

    function __construct(array $config = [])
    {
        parent::__construct($config);

        $class = $this->item_class;
        $this->item_table = $class::tableName();
        $class = $this->item_value_class;
        $this->item_value_table = $class::tableName();
        $class = $this->property_class;
        $this->property_table = $class::tableName();
        $class = $this->property_value_class;
        $this->property_value_table = $class::tableName();
    }

    public function filtering($criteria, $filter) {
        $filter = static::prepare_filter($filter);

        $query_where = [];

        if (!empty($filter['p'])) {
            foreach ($filter['p'] as $pKey => $val) {
                $pKey = intval($pKey);
                $val = array_diff($val, ['']);
                if (!empty($val)) {
                    $query_where[] = '[property_id]=' . $pKey . ' AND [value_id] IN ('.implode(',', $val).')';
                }
            }
        }

        if (!empty($query_where)) {
            $query = $this->replace('
                (
                    SELECT [item_id], COUNT(id) as cnt_id, COUNT(DISTINCT [property_id]) as cnt_property
                    FROM `[item_value_table]` ivt
                    WHERE ' . implode(' OR ', $query_where) . '
                    GROUP BY [item_id]
                    HAVING cnt_property='.count($query_where).'
                ) as props
            ');
            $on = $this->replace('props.[item_id] = [item_table].id');

            $criteria->rightJoin($query, $on);
        }

        return $criteria;
    }

    public function getFilter($criteria = false, $filter = [], $basicFilter = [], $cacke_key_options = []) {
        $filter = static::prepare_filter($filter);
        $basicFilter = static::prepare_filter($basicFilter);

        if (!is_array($filter)) $filter = [];
        if (!is_array($basicFilter)) $basicFilter = [];

        $props = ArrayHelper::index($this->property_criteria->all(), 'id');

        $filter = ArrayHelper::merge($basicFilter, $filter);

        $cacheKey = [['filter', $filter, $basicFilter, $cacke_key_options]];
        if (true || !($filterRes = Yii::$app->cache->get($cacheKey))) {
            $filterRes = [];
            $filterRes['basic'] = [];
            $filterRes['current'] = [];

            $filterRes['basic'] = $this->getFilterPropertiesStatistic($criteria, $basicFilter, $props);

            if (serialize($basicFilter) == serialize($filter)) {
                $filterRes['current'] = $filterRes['basic'];
            } else {
                $filterRes['current'] = $this->getFilterPropertiesStatistic($criteria, $filter, $props);

                if (!empty($filter['p'])) {
                    foreach ($filter['p'] as $prop_id => $values) {
                        if (!empty($values) && implode('', $values) != '') {
                            $newFilter = $filter;

                            unset($newFilter['p'][$prop_id]);
                            $statistic = $this->getFilterPropertiesStatistic($criteria, $newFilter, $props);
                            $filterRes['current'][$prop_id] = $statistic[$prop_id];
                        }
                    }
                }
            }

            Yii::$app->cache->set($cacheKey, $filterRes, 86400, new TagDependency(['tags' => 'filter']));
        }
        $filterRes['props'] = $props;

        return $filterRes;
    }

    public function getFilterPropertiesStatistic($criteria, $filter = [], $props = []) {
        $item_class = $this->item_class;

        if ($criteria) {
            $clone_criteria = clone $criteria;
        } else {
            $clone_criteria = $item_class::find();
        }
        //$clone_criteria->select($this->item_table.'.id');
        $this->filtering($clone_criteria, $filter);
        $query_goods = $clone_criteria->createCommand()->rawSql;

        $query = $this->replace('
            SELECT property_id, val, COUNT(DISTINCT item_id) cnt_item, MAX(value_title) as value_title, MAX(value_weight) as value_weight, MAX(value_id) as value_id
            FROM (
                SELECT [item_uniq_id] as item_id, ivt.[property_id] as property_id, COALESCE(ivt.value_id, ivt.[value_enum], ivt.[value_boolean]) as val, property_value.title as value_title, property_value.weight as value_weight, property_value.id as value_id
                FROM [item_value_table] ivt
                RIGHT JOIN ('.$query_goods.') as item_table_filtered ON (item_table_filtered.id = ivt.[item_id])
                LEFT JOIN [property_value_table] property_value ON (property_value.id = ivt.[value_id])
                WHERE (1=1)'. (!empty($props)?(' AND ivt.[property_id] IN (' . implode(',', array_keys($props)) . ')'):'') .'
            ) as prop_value
            GROUP BY property_id, val
            ORDER BY value_weight, value_id ASC
        ');
        $filter_rows = Yii::$app->db->createCommand($query)->queryAll();

        $filterRes = [];

        if (!empty($filter_rows)) {
            foreach ($filter_rows as $filter_row) {
                if (!empty($props[$filter_row['property_id']])) {
                    $property = $props[$filter_row['property_id']];

                    if (empty($property->property_type) || in_array($property->property_type, [$this->property_types['object'], $this->property_types['number']])) {
                        if (empty($filterRes[$filter_row['property_id']]['count'])) {
                            $filterRes[$filter_row['property_id']]['count'] = $filter_row['cnt_item'];
                        } else {
                            $filterRes[$filter_row['property_id']]['count'] += $filter_row['cnt_item'];
                        }
                    }

                    if (empty($property->property_type) || $property->property_type == $this->property_types['object']) {
                        $filterRes[$filter_row['property_id']]['values'][$filter_row['val']] = $filter_row['cnt_item'];
                        $filterRes[$filter_row['property_id']]['value_title'][$filter_row['val']] = $filter_row['value_title'];
                        $filterRes[$filter_row['property_id']]['value_weight'][$filter_row['val']] = $filter_row['value_weight'];
                    } elseif($property->property_type == $this->property_types['number']) {
                        if (empty($filterRes[$filter_row['property_id']]['range'])) {
                            $filterRes[$filter_row['property_id']]['range'] = [$filter_row['val'], $filter_row['val']];
                        } else {
                            if ($filterRes[$filter_row['property_id']]['range'][0] > $filter_row['val']) $filterRes[$filter_row['property_id']]['range'][0] = $filter_row['val'];
                            if ($filterRes[$filter_row['property_id']]['range'][1] < $filter_row['val']) $filterRes[$filter_row['property_id']]['range'][1] = $filter_row['val'];
                        }
                    } elseif($property->property_type == $this->property_types['boolean']) {
                        if ($filter_row['val'] == 1) $filterRes[$filter_row['property_id']]['count'] = $filter_row['cnt_good'];
                    }
                }
            }
        }

        return $filterRes;
    }

    public function getFilterItemNumberStatistic($criteria, $filter, $field) {
        $item_class = $this->item_class;

        if ($criteria) {
            $clone_criteria = clone $criteria;
        } else {
            $clone_criteria = $item_class::find();
        }
        $this->filtering($criteria, $filter);
        $query_items = $criteria->createCommand()->rawSql;

        $query = $this->replace('
            SELECT MAX(it.'.$field.') max_value, MIN(it.'.$field.') min_value 
            FROM [item_table] it
            RIGHT JOIN ('.$query_items.') as filter_item ON (filter_item.id = it.id)
        ');

        $res = [];
        $filter_rows = Yii::$app->db->createCommand($query)->queryOne();
        if (!empty($filter_rows)) {
            $res['min'] = floor($filter_rows['min_value']);
            $res['max'] = ceil($filter_rows['max_value']);
        }

        return $res;
    }

    public function replace($query) {
        $replaces = [
            '[item_id]' => $this->item_id,
            '[item_uniq_id]' => $this->item_uniq_id,
            '[property_id]' => $this->property_id,
            '[value_id]' => $this->value_id,
            '[value_enum]' => $this->value_enum,
            '[value_boolean]' => $this->value_boolean,
            '[item_table]' => $this->item_table,
            '[item_value_table]' => $this->item_value_table,
            '[property_table]' => $this->property_table,
            '[property_value_table]' => $this->property_value_table,
        ];

        $query = str_replace(array_keys($replaces), array_values($replaces), $query);
        $query = str_replace(array_keys($replaces), array_values($replaces), $query);

        return $query;
    }

    public static function prepare_filter($filter) {
        if (!empty($filter['p'])) {
            foreach ($filter['p'] as $property_id => $values) {
                if (is_string($values)) {
                    $filter['p'][$property_id] = array_values(array_unique(array_diff(preg_split('/\s*\,\s*/', $values), [''])));
                }
            }
        }

        if (!empty($filter['d'])) {
            foreach ($filter['d'] as $property_id => $values) {
                if (is_string($values)) {
                    $filter['d'][$property_id] = array_splice(preg_split('/\s*\,\s*/', $values), 0, 2);
                }
            }
        }

        if (!empty($filter['c'])) {
            if (is_string($filter['c'])) {
                $filter['c'] = array_splice(preg_split('/\s*\,\s*/', $filter['c']), 0, 2);
                if (!empty($filter['c'][0])) $filter['c'][0] = preg_replace('/[^0-9\.\,]/', '', $filter['c'][0]);
                if (!empty($filter['c'][1])) $filter['c'][1] = preg_replace('/[^0-9\.\,]/', '', $filter['c'][1]);
            }
        }

        return $filter;
    }
}