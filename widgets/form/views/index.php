<?php
use app\assets\PjaxAsset;

PjaxAsset::register($this);

echo $this->render($this->context->template, ['model' => $model, 'options' => $options]);