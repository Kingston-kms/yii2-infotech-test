<?php

use yii\db\Migration;

class m250305_072206_create_book_and_author_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique()
        ]);

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string(50)->defaultValue(''),
            'title' => $this->string(255)->defaultValue(''),
            'year' => $this->integer()->notNull()->defaultValue(1900),
            'image_url' => $this->string(2048)->defaultValue(''),
            'description' => $this->string(2000)->defaultValue(''),
        ]);

        $this->createIndex('idx_book_year', '{{%book}}', 'year');

        $this->createTable('{{%book_author}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(10)->notNull(),
            'author_id' => $this->integer(10)->notNull()
        ]);
        $this->createIndex('idx_book_author_unq', '{{%book_author}}', ['book_id', 'author_id'], true);
        $this->addForeignKey('fk_book_ba', '{{%book_author}}','book_id', '{{%book}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_author_ba', '{{%book_author}}', 'author_id', '{{%author}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_author}}');
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%author}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250305_072206_create_book_and_author_tables cannot be reverted.\n";

        return false;
    }
    */
}
