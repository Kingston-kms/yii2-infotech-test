<?php

namespace app\rbac\filters;

use app\rbac\Constants;

class UpdateBookAccessControl extends \yii\filters\AccessControl
{
    public $only = [
        'update'
    ];
    public $rules = [
        [
            'actions' => ['update'],
            'allow' => true,
            'roles' => [Constants::UPDATE_BOOK],
        ],
    ];
}