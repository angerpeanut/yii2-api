<?php
/**
 * @author peanut   angerpeanut@gmail.com
 * @since 1.0       2016-08-23 14:52
 */
namespace common\rest;

use yii\rest\Serializer;

class Serialize extends Serializer
{
    public $result = [];

    //返回成功
    const SUCCESS = 200;

    //返回失败，把message提示给用户
    const ERROR = 300;

    //参数错误，只会在开发期间出现
    const PARAM_ERROR = 400;

    //服务器内部错误
    const INNER_ERROR = 500;

    protected function serializeModelErrors($model)
    {
        $error = $model->getFirstErrors();
        if (!empty($error) && is_array($error)) {
            foreach ($error as $key => $value) {
                $error = $value;
            }
        } elseif (!empty($error)) {

        } else {
            $error = '请求失败，请重试';
        }
        return self::result(self::ERROR, null, $error);
    }

    protected function serializeModel($model)
    {
        $res =  parent::serializeModel($model);
        return self::result(self::SUCCESS, $res, "获取成功");
    }

    protected function serializeDataProvider($dataProvider)
    {
        $res =  parent::serializeDataProvider($dataProvider);
        return self::result(self::SUCCESS, $res, "获取成功");
    }

    public static function result($status, $data, $msg)
    {
        $result = [
            'status' => $status,
            'data' => $data,
            'msg' => $msg,
        ];
        return $result;
    }

}