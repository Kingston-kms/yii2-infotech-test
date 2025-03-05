<?php

use app\rbac\Constants;
use yii\db\Migration;

class m250305_062803_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // add "createBook" permission
        $createBook = $auth->createPermission(Constants::CREATE_BOOK);
        $createBook->description = 'Create a book';
        $auth->add($createBook);

        // add "updateBook" permission
        $updateBook = $auth->createPermission(Constants::UPDATE_BOOK);
        $updateBook->description = 'Update book';
        $auth->add($updateBook);

        $deleteBook = $auth->createPermission(Constants::DELETE_BOOK);
        $deleteBook->description = 'Delete book';
        $auth->add($deleteBook);

        // add "user" role and give this role the "createBook" permission
        $user = $auth->createRole(\app\models\User::RBAC_ROLE_USER);
        $auth->add($user);
        $auth->addChild($user, $createBook);
        $auth->addChild($user, $updateBook);
        $auth->addChild($user, $deleteBook);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250305_062803_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
