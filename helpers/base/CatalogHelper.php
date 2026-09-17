<?php
namespace app\helpers\base;

use app\components\base\CActiveQuery;
use app\models\CatalogGood;
use app\models\CatalogSection;
use app\models\SystemSettings;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class CatalogHelper {
    public static $price_type_id = false;

    /**
     * @param CActiveQuery $criteria
     * @param $section
     * @param $filter
     * @return mixed
     */
    public static function filtering($criteria, $section, $filter) {
        $filter = static::prepare_filter($filter);

        static::sectionPageFilter($criteria);
        if ($section) $criteria->joinWith('section s')->andWhere(['>=', 's.lft', $section->lft])->andWhere(['<=', 's.rgt', $section->rgt]);

        if (!empty($filter['search'])) {
            $parts = preg_split('/\s+/', trim($filter['search']));
            $searchFields = ['catalog_good.title', 'catalog_good.articul', 'catalog_good.text'];
            $orWhere = ['OR'];
            foreach ($searchFields as $searchField) {
                $partWhere = ['AND'];
                foreach ($parts as $part) {
                    $partWhere[] = ['LIKE', $searchField, $part];
                }
                $orWhere[] = $partWhere;
            }

            $criteria->andWhere($orWhere);
        }
        if (!empty($filter['title'])) $criteria->andWhere(['LIKE', 'catalog_good.title', $filter['title']]);

        if (!empty($filter['c'])) {
            $criteria->joinWith('prices gprice', false)->andWhere(['OR', ['gprice.price_type_id' => CatalogHelper::getPriceTypeId()], ['gprice.price_type_id' => null]]);
            if (!empty($filter['c'][0])) $criteria->andWhere(['>=', 'gprice.value', floatval($filter['c'][0])]);
            if (!empty($filter['c'][0]) && !empty($filter['c'][1])) $criteria->andWhere(['<=', 'gprice.value', floatval($filter['c'][1])]);
            if (empty($filter['c'][0]) && !empty($filter['c'][1])) $criteria->andWhere(['OR', ['gprice.value' => null], ['<=', 'gprice.value', floatval($filter['c'][1])]]);
        }

        $query_where = [];

        if (!empty($filter['p'])) {
            foreach ($filter['p'] as $pKey => $val) {
                $pKey = intval($pKey);
                $val = array_diff($val, ['']);
                if (!empty($val)) {
                    $query_where[] = 'property_id=' . $pKey . ' AND variant_id IN ('.implode(',', $val).')';
                }
            }
        }

        if (!empty($filter['f'])) {
            foreach ($filter['f'] as $pKey => $val) {
                if ($val == 1) {
                    $query_where[] = 'property_id=' . $pKey . ' AND value_boolean=1';
                }
            }
        }

        if (!empty($filter['e'])) {
            $criteria->andWhere(['>', 'catalog_good.quantity', 0]);
        }

        if (!empty($filter['d'])) {
            foreach ($filter['d'] as $pKey => $val) {
                $pKey = intval($pKey);

                $filter_left = !empty($val[0])?floatval(preg_replace('/[^0-9\.]/', '', $val[0])):false;
                $filter_right = !empty($val[1])?floatval(preg_replace('/[^0-9\.]/', '', $val[1])):false;
                $filter_left_max = !empty($val[2])?floatval(preg_replace('/[^0-9\.]/', '', $val[2])):false;
                $filter_right_max = !empty($val[3])?floatval(preg_replace('/[^0-9\.]/', '', $val[3])):false;

                $where = '';

                if ($filter_left && $filter_left != $filter_left_max) $where .= ' AND value_enum >= ' . $filter_left;
                if ($filter_right && $filter_right != $filter_right_max) $where .= ' AND value_enum <= ' . $filter_right;

                if (!empty($where)) $query_where[] = 'property_id=' . $pKey . $where;
            }
        }

        if (!empty($query_where)) {
            $query = '
                SELECT good_id, COUNT(id) as cnt_id, COUNT(DISTINCT property_id) as cnt_property
                FROM `catalog_good_property` gp
                WHERE ' . implode(' OR ', $query_where) . '
                GROUP BY good_id
                HAVING cnt_property='.count($query_where).'
            ';

            $criteria->rightJoin('('.$query.') as props', 'props.good_id = catalog_good.id');
        }

        return $criteria;
    }

    /**
     * @param $filter
     * @param CatalogSection $section
     * @return array|mixed
     */
    public static function getFilter($section, $filter = [], $basicFilter = [], $additionalProps = []) {
        $filter = static::prepare_filter($filter);
        $basicFilter = static::prepare_filter($basicFilter);
        /**
         * @var CatalogProperty $property
         */
        if (!is_array($filter)) $filter = [];
        if (!is_array($basicFilter)) $basicFilter = [];

        $propsCriteria = CatalogProperty::find()->published()->orderBy('weight');
        if (count($additionalProps) > 0) {
            $orWhere = ['OR', ['=', 'catalog_property.is_filter', 1], ['id' => $additionalProps]];

            $propsCriteria->andWhere($orWhere);
        } else {
            $orWhere = ['OR', ['=', 'catalog_property.is_filter', 1]];

            $propsCriteria->andWhere($orWhere);
        }
        if (!empty($exclude_props)) $propsCriteria->andWhere(['<>', 'catalog_property.id', $exclude_props]);
        $props = ArrayHelper::index($propsCriteria->all(), 'id');

        $filter = ArrayHelper::merge($basicFilter, $filter);

        $cacheKey = [['filter', $section->id, $filter, $basicFilter, static::getPriceTypeId(), $additionalProps]];
        if (true || !($filterRes = Yii::$app->cache->get($cacheKey))) {
            $filterRes = [];
            $filterRes['basic'] = [];
            $filterRes['current'] = [];

            $filterRes['basic'] = static::getFilterPropertiesStatistic($section, $basicFilter, $props);

            if (serialize($basicFilter) == serialize($filter)) {
                $filterRes['current'] = $filterRes['basic'];
            } else {
                $filterRes['current'] = static::getFilterPropertiesStatistic($section, $filter, $props);

                if (!empty($filter['p'])) {
                    foreach ($filter['p'] as $prop_id => $values) {
                        if (!empty($values) && implode('', $values) != '') {
                            $newFilter = $filter;

                            unset($newFilter['p'][$prop_id]);
                            $statistic = static::getFilterPropertiesStatistic($section, $newFilter, $props);
                            $filterRes['current'][$prop_id] = $statistic[$prop_id];
                        }
                    }
                }
            }
            //$filterRes['flags'] = static::getFilterFlagsStatistic($section, $filter);

            $filterRes['price'] = static::getFilterPriceStatistic($section, $basicFilter, CatalogHelper::getPriceTypeId());

            Yii::$app->cache->set($cacheKey, $filterRes, 86400, new TagDependency(['tags' => 'catalog']));
        }
        $filterRes['props'] = $props;

        return $filterRes;
    }

    public static function getFilterFlagsStatistic($section, $filter) {
        $criteria = CatalogGood::find()->published();
        static::filtering($criteria, $section, $filter);
        $query_goods = $criteria->createCommand()->rawSql;

        $query = '
                SELECT SUM(cg.novelty) as novelty_cnt, SUM(cg.action) as action_cnt, SUM(cg.hit) as hit_cnt 
                FROM ('.$query_goods.') as cg
            ';

        $result = [
            'novelty' => 0,
            'action' => 0,
            'hit' => 0,
        ];
        $filter_rows = Yii::$app->db->createCommand($query)->queryOne();
        if (!empty($filter_rows)) {
            if (!empty($filter_rows['novelty_cnt'])) $result['novelty'] = $filter_rows['novelty_cnt'];
            if (!empty($filter_rows['action_cnt'])) $result['action'] = $filter_rows['action_cnt'];
            if (!empty($filter_rows['hit_cnt'])) $result['hit'] = $filter_rows['hit_cnt'];
        }

        return $result;
    }

    public static function getFilterPriceStatistic($section, $filter, $price_id) {
        $criteria = CatalogGood::find()->select('catalog_good.id')->published();
        static::filtering($criteria, $section, $filter);
        $query_goods = $criteria->createCommand()->rawSql;

        $query = '
                SELECT MAX(cgp.value) max_price, MIN(cgp.value) min_price 
                FROM catalog_good_price cgp
                RIGHT JOIN ('.$query_goods.') as filter_good ON (filter_good.id = cgp.good_id)
                WHERE cgp.price_type_id='.$price_id.'
            ';

        $filter_rows = Yii::$app->db->createCommand($query)->queryOne();
        if (!empty($filter_rows)) {
            $filter_rows['min_price'] = floor($filter_rows['min_price']);
            $filter_rows['max_price'] = ceil($filter_rows['max_price']);
        }

        return $filter_rows;
    }

    public static function getFilterPropertiesStatistic($section, $filter, $props) {
        /**
         * @var CatalogProperty $property
         */
        $criteria = CatalogGood::find()->select('catalog_good.id')->published();
        static::filtering($criteria, $section, $filter);
        $query_goods = $criteria->createCommand()->rawSql;

        $query = '
                SELECT property_id, val, COUNT(good_id) cnt_good, MAX(variant_title) as variant_title, MAX(variant_weight) as variant_weight, MAX(variant_id) as variant_id
                FROM (
                    SELECT gp.good_id, gp.property_id, COALESCE(gp.variant_id, gp.value_enum, gp.value_boolean) as val, variant.title as variant_title, variant.weight as variant_weight, variant.id as variant_id
                    FROM catalog_good_property gp
                    RIGHT JOIN ('.$query_goods.') as filter_good ON (filter_good.id = gp.good_id)
                    LEFT JOIN catalog_property_variant variant ON (variant.id = gp.variant_id)
                    WHERE (1=1)'. (!empty($props)?(' AND gp.property_id IN (' . implode(',', array_keys($props)) . ')'):'') .'
                ) as prop_value
                GROUP BY property_id, val
                ORDER BY variant_weight, variant_id ASC
            ';

        $filter_rows = Yii::$app->db->createCommand($query)->queryAll();

        $filterRes = [];

        if (!empty($filter_rows)) {
            foreach ($filter_rows as $filter_row) {
                if (!empty($props[$filter_row['property_id']])) {
                    $property = $props[$filter_row['property_id']];

                    if (!in_array($property->property_type, [3])) {
                        if (empty($filterRes[$filter_row['property_id']]['count'])) {
                            $filterRes[$filter_row['property_id']]['count'] = $filter_row['cnt_good'];
                        } else {
                            $filterRes[$filter_row['property_id']]['count'] += $filter_row['cnt_good'];
                        }
                    }

                    if ($property->property_type == 1) {
                        $filterRes[$filter_row['property_id']]['variants'][$filter_row['val']] = $filter_row['cnt_good'];
                        $filterRes[$filter_row['property_id']]['variant_title'][$filter_row['val']] = $filter_row['variant_title'];
                        $filterRes[$filter_row['property_id']]['variant_weight'][$filter_row['val']] = $filter_row['variant_weight'];
                    } elseif($property->property_type == 2) {
                        if (empty($filterRes[$filter_row['property_id']]['range'])) {
                            $filterRes[$filter_row['property_id']]['range'] = [$filter_row['val'], $filter_row['val']];
                        } else {
                            if ($filterRes[$filter_row['property_id']]['range'][0] > $filter_row['val']) $filterRes[$filter_row['property_id']]['range'][0] = $filter_row['val'];
                            if ($filterRes[$filter_row['property_id']]['range'][1] < $filter_row['val']) $filterRes[$filter_row['property_id']]['range'][1] = $filter_row['val'];
                        }
                    } elseif($property->property_type == 3) {
                        if ($filter_row['val'] == 1) $filterRes[$filter_row['property_id']]['count'] = $filter_row['cnt_good'];
                    }
                }
            }
        }

        return $filterRes;
    }

    public static function getPriceTypeId() {
        if (static::$price_type_id === false) {
            static::$price_type_id = SystemSettings::getParam('catalog', 'price_id', 1);
        }

        return static::$price_type_id;
    }

    public static function sectionPageFilter($criteria)
    {
    }

    public static function clearFilterParams($filter)
    {
        if (!empty($filter['c'])) {
            if (!empty($filter['c'][0])) $filter['c'][0] = preg_replace('/[^0-9\.\,]/', '', $filter['c'][0]);
            if (!empty($filter['c'][1])) $filter['c'][1] = preg_replace('/[^0-9\.\,]/', '', $filter['c'][1]);
        }

        return $filter;
    }

    /**
     * @param CatalogProperty $property
     * @param $filter_property
     */
    public static function orderVariants($property, $filter_property) {
        if ($property->sort_type == 1) { // Порядок
            foreach ($filter_property['variant_title'] as $k => $v) {
                if (isset($filter_property['variant_weight'][$k]) && $filter_property['variant_weight'][$k] != '') {
                    $filter_property['variant_title'][$k] = [$v, $filter_property['variant_weight'][$k]];
                } else {
                    $filter_property['variant_title'][$k] = [$v, 1000000];
                }
            }
            uasort($filter_property['variant_title'], function ($a, $b) {
                if (floatval($a[1]) > floatval($b[1])) return 1;
                if (floatval($a[1]) < floatval($b[1])) return -1;
                return 0;
            });
            foreach ($filter_property['variant_title'] as $k => $v) {
                $filter_property['variant_title'][$k] = $v[0];
            }
        }
        if ($property->sort_type == 2) { // Строка
            uasort($filter_property['variant_title'], function ($a, $b) {
                if ($a > $b) return 1;
                if ($a < $b) return -1;
                return 0;
            });
        }
        if ($property->sort_type == 3) { // Число
            uasort($filter_property['variant_title'], function ($a, $b) {
                if (floatval($a) > floatval($b)) return 1;
                if (floatval($a) < floatval($b)) return -1;
                return 0;
            });
        }

        return $filter_property;
    }

    public static function prepare_filter($filter) {
        if (!empty($filter['p'])) {
            foreach ($filter['p'] as $property_id => $variants) {
                if (is_string($variants)) {
                    $filter['p'][$property_id] = array_values(array_unique(array_diff(preg_split('/\s*\,\s*/', $variants), [''])));
                }
            }
        }

        if (!empty($filter['d'])) {
            foreach ($filter['d'] as $property_id => $variants) {
                if (is_string($variants)) {
                    $filter['d'][$property_id] = array_splice(preg_split('/\s*\,\s*/', $variants), 0, 2);
                }
            }
        }

        if (!empty($filter['c'])) {
            if (is_string($filter['c'])) {
                $filter['c'] = array_splice(preg_split('/\s*\,\s*/', $filter['c']), 0, 2);
            }
        }

        return $filter;
    }
}