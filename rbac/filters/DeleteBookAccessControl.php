<?php

namespace app\rbac\filters;

use app\rbac\Constants;

class DeleteBookAccessControl extends \yii\filters\AccessControl
{
    public $only = [
        'delete'
    ];

    public $rules = [
        [
            'actions' => ['delete'],
            'allow' => true,
            'roles' => [Constants::DELETE_BOOK],
        ],
    ];
}