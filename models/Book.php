<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property int $id
 * @property string|null $isbn
 * @property string|null $title
 * @property int $year
 * @property string|null $image_url
 * @property string|null $description
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    public array $book_authors = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => ''],
            [['year'], 'default', 'value' => 1900],
            [['year'], 'integer'],
            [['isbn'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
            [['image_url'], 'string', 'max' => 2048],
            [['description'], 'string', 'max' => 2000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'Isbn',
            'title' => 'Title',
            'year' => 'Year',
            'image_url' => 'Image Url',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('bookAuthors');
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

}
