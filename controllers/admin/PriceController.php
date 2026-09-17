<?php
namespace app\controllers\admin;

use app\controllers\base\AdminController;
use app\models\Service;
use app\models\ServicePrice;
use Yii;
use yii\web\UploadedFile;

class PriceController extends AdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDownload() {
        $path = Yii::getAlias('@app/runtime/price.csv');
        $csv_table = [[
            'ID',
            'Наименование',
            'Цена',
            'От?',
            'Консультационная услуга?',
        ]];
        $services = Service::find()->published()->where(['>', 'depth', 0])->orderBy('lft')->all();

        $services_path = [];
        /** @var Service[] $services */
        foreach ($services as $service) {
            $services_path[$service->depth - 1] = $service->title;
            $services_path = array_slice($services_path, 0, $service->depth);
            $csv_table[] = [$service->id, implode(' / ', $services_path)];

            if ($service->prices) {
                foreach ($service->prices as $price) {
                    $csv_table[] = [
                        $price->id,
                        $price->title,
                        $price->price,
                        $price->price_from?1:0,
                        $price->is_consult?1:0,
                    ];
                }
            }
        }

        $fp = fopen($path, 'w');

        foreach ($csv_table as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        return \Yii::$app->response->sendContentAsFile(file_get_contents($path), 'price.csv', [
            'mimeType' => 'application/csv',
            'inline'   => true
        ]);
    }

    public function actionUpload() {
        $result = true;
        $csv_table = [];
        $file = UploadedFile::getInstanceByName('file');
        if (!empty($file->size) && empty($file->error)) {
            $row = 1;
            if (($handle = fopen($file->tempName, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 5000)) !== FALSE) {
                    if ($row == 0) {
                        $csv_table[] = $data;
                    }
                    $row = 0;
                }
                fclose($handle);
            }

            if (!empty($csv_table)) {
                $service = false;
                $last_weight = 10;
                ServicePrice::updateAll(['public' => 2]);
                foreach ($csv_table as $row) {
                    if (empty($row[2])) {
                        $service = Service::find()->where(['id' => $row[0]])->one();
                        $last_weight = 10;
                    } else {
                        $price = false;
                        if (!empty($row[0])) {
                            $price = ServicePrice::find()->where(['id' => $row[0]])->one();
                        }
                        if (!$price) $price = new ServicePrice();

                        $price->service_id = $service->id;
                        $price->title = $row[1];
                        $price->price = $row[2];
                        $price->price_from = !empty($row[3]);
                        $price->is_consult = !empty($row[4]);
                        $price->weight = $last_weight;
                        $price->public = 1;
                        $last_weight += 10;

                        $price->save();
                    }
                }
                ServicePrice::updateAll(['public' => 0], ['public' => 2]);
            }
        } else {
            $result = false;
        }

        return $this->render('upload', ['result' => $result]);
    }
}