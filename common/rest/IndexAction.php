<?php
/**
 * @author peanut   angerpeanut@gmail.com
 * @since 1.0       2016-08-23 13:59
 */
namespace common\rest;


use yii\data\ActiveDataProvider;

class IndexAction extends \yii\rest\IndexAction
{
    public $condition = [];

    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        return new ActiveDataProvider([
            'query' => $modelClass::find()->where($this->condition),
        ]);
    }
}