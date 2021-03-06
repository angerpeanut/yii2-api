<?php
/**
 * @author peanut   angerpeanut@gmail.com
 * @since 1.0       2016-08-23 16:06
 */

namespace v1\controllers;

use common\rest\ApiController;
use common\models\User;
use common\rest\Serialize;

class IndexController extends ApiController
{
    public function init()
    {
        $this->modelClass = User::className();
        parent::init();
    }


    public function actionHello()
    {
        return Serialize::success("Hello,World!");
    }
}