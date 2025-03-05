<?php

namespace app\rbac\filters;

use app\rbac\Constants;

class CreateBookAccessControl extends \yii\filters\AccessControl
{
    public $only = [
        'create'
    ];
    public $rules = [
        [
            'actions' => ['create'],
            'allow' => true,
            'roles' => [Constants::CREATE_BOOK],
        ],
    ];
}