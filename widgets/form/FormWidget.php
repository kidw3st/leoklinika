<?php

namespace app\widgets\form;

use app\components\base\CActiveRecord;
use app\helpers\base\SystemHelper;
use Yii;

class FormWidget extends \yii\base\Widget {
    public $model = false;
    public $classname = false;
    public $scenario = false;
    public $options;
    public $template;
    public $pjax = false;
    public $pjax_id = '';
    public $pjax_block_auto = true;
    public $afterSave = false;
    public $form_action = false;
    public $validate_commands = [];
    public $save_commands = ['save'];

    public function init()
    {
        if ($this->pjax && $this->pjax_id == '') {
            if ($this->pjax === true) {
                $this->pjax_id = $this->id . '_pjax';
            } else {
                $this->pjax_id = $this->pjax;
            }
        }
        parent::init();
    }

    public function getForm_attributes($form_action = false) {
        $res[] = 'method="post" enctype="multipart/form-data"';
        if ($this->pjax) $res[] = 'data-pjax-block="#'.$this->pjax_id.'"';
        if ($this->form_action || $form_action) {
            if ($form_action) {
                $res[] = 'action="' . $form_action . '"';
            } else {
                $res[] = 'action="' . $this->form_action . '"';
            }
        } else {
            $res[] = 'action="'.SystemHelper::LanguageLink(Yii::$app->request->url).'"';
        }

        return implode(' ', $res);
    }

    public function run()
    {
        /** @var CActiveRecord $model */

        $success = false;

        if ($this->model === false) {
            $cn = $this->classname;
            $model = new $cn();
        } else {
            $model = $this->model;
        }
        if ($this->scenario !== false) $model->scenario = $this->scenario;
        $model->formNameSuffix = $this->id;

        if(Yii::$app->request->isPost) {
            $model->command = Yii::$app->request->post('command', 'save');

            if ($model->load(Yii::$app->request->post())) {
                if (in_array($model->command, $this->validate_commands)) $model->validate();
                if (in_array($model->command, $this->save_commands) && $model->save()) {
                    $model->success = true;
                    $success = true;

                    if ($this->afterSave) {
                        $func = $this->afterSave;
                        if (is_callable($func)) {
                            $func($this, $model);

                            if ($this->scenario !== false) $model->scenario = $this->scenario;
                            $model->formNameSuffix = $this->id;
                        }
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'options' => $this->options,
            'success' => $success,
        ]);
    }
}