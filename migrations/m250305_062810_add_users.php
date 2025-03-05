<?php

use yii\db\Migration;

class m250305_062810_add_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $password = 'Yii2User01*';
        $users = [
            [
                'username' => 'User',
                'email' => 'user@yii-it.tech',
                'role' => \app\models\User::RBAC_ROLE_USER,
            ],
        ];

        foreach ($users as $user)
        {
            $userRecord = new \app\models\User($user);
            $userRecord->setPassword($password);
            $userRecord->generateAuthKey();
            if ($userRecord->save()) {
                // the following three lines were added:
                $auth = \Yii::$app->authManager;
                $authorRole = $auth->getRole(\app\models\User::RBAC_ROLE_USER);
                $auth->assign($authorRole, $userRecord->getId());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \app\models\User::deleteAll(['email' => 'user@yii-it.tech']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250305_062810_add_users cannot be reverted.\n";

        return false;
    }
    */
}
