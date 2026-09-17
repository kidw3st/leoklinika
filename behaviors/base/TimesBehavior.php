<?php
namespace app\behaviors\base;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class TimesBehavior extends Behavior {
    public $attributes = ['handle' => 'title'];
    public $tree_attributes = [];//['handle_tree' => 'handle',];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeInsert($event)
    {
        $this->owner->{$this->attributes['create']} = date('Y-m-d H:i:s');
        $this->owner->{$this->attributes['update']} = date('Y-m-d H:i:s');
    }

    public function beforeUpdate($event)
    {
        $this->owner->{$this->attributes['update']} = date('Y-m-d H:i:s');
    }
}