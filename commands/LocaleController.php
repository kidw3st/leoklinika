<?
namespace app\commands;

use app\helpers\base\AdminHelper;
use app\models\Language;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class LocaleController extends Controller
{
    public function actionFillContent() {
        $main_language = Language::find()->andWhere(['is_main' => 1])->one();
        $language_ids = ArrayHelper::getColumn(Language::find()->andWhere(['NOT', ['is_main' => 1]])->all(), 'id');

        if ($main_language && !empty($language_ids)) {
            $models = AdminHelper::getModels();

            foreach ($models as $model) {
                $cn = $model['class'];

                $options = $cn::getOptions();

                $locale_fields = [];
                if (!empty($options['fields'])) {
                    foreach ($options['fields'] as $field_name => $field) {
                        if (!empty($field['locale'])) {
                            $locale_fields[] = $field_name;
                        }
                    }
                }

                if (!empty($locale_fields)) {
                    $table = $cn::tableName() . '_locale';

                    foreach ($language_ids as $language_id) {
                        $sql = 'INSERT IGNORE INTO `' . $table . '` (' . implode(', ', $locale_fields) . ', locale_parent_id, language_id) SELECT ' . implode(', ', $locale_fields) . ', locale_parent_id, ' . $language_id . ' AS locale_parent_id FROM `' . $table . '` src_table WHERE src_table.language_id=' . $main_language->id;
                        Yii::$app->db->createCommand($sql)->execute();
                    }
                }
            }
        }
    }
}