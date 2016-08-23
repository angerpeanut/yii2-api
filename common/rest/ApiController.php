<?php
/**
 * @author peanut   angerpeanut@gmail.com
 * @since 1.0       2016-08-23 16:11
 */
namespace common\rest;

use yii\base\Object;
use yii\rest\ActiveController;
use yii\web\Response;

class ApiController extends ActiveController
{
    //index的查询条件
    public $condition = [];

    public $serializer = [
        'class' => Serialize::class,
        'collectionEnvelope' => 'list',
    ];

    public function init()
    {
        if (!$this->modelClass instanceof Object) {
            $this->modelClass = \Yii::createObject($this->modelClass);
        }
        parent::init();
        self::initSearchCondition();
    }

    protected function initSearchCondition()
    {
        $fields = $this->modelClass->attributes();
        foreach ($fields as $key => $value) {
            if (isset($_GET[$value]) && $_GET[$value] != '') {
                $this->condition[$value] = $_GET[$value];
            }
        }
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'condition' => $this->condition,
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'yii\rest\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }


}