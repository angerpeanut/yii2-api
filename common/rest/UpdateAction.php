<?php
/**
 * @author peanut   angerpeanut@gmail.com
 * @since 1.0       2016-08-23 17:36
 */
namespace common\rest;

use Yii;

class UpdateAction extends \yii\rest\UpdateAction
{
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $res = $model->save();
//        if ($model->hasAttribute('errors')) {
//            echo $model->getAttribute('errors')."\n";
//        }else{
//            echo 'n';
//        }
//        $model->setAttribute('errors','error');
//        if ($res === false && !$model->hasErrors()) {
//            return Serialize::error('未知错误，请重试');
//        } elseif ($res === false && $model->hasErrors()) {
//            foreach ($model->getFirstErrors() as $value) {
//                $error = $value;
//            }
//            return Serialize::error($error);
//        }
        return $model;

//        return Serialize::success($model, '修改成功');
    }
}