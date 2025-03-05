<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;

class BookForm extends Model
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $isbn = null;
    public ?int $year = null;
    public ?string $image_url = null;
    public ?string $description = null;
    public array $authors = [];

    public function rules(): array
    {
        return [
            [['title', 'isbn', 'description', 'year', 'image_url', 'authors'], 'required'],
            [['year'], 'integer'],
            [['description', 'title', 'isbn', 'image_url'], 'filter', 'filter' => 'strip_tags']
        ];
    }

    public function createBook(): bool
    {
        $db = \Yii::$app->db;
        $dbTransaction = $db->beginTransaction();
        $book = new Book($this->getAttributes(null, ['authors']));
        if (!$book->save() && empty($book->getErrors())) {
            throw new ServerErrorHttpException('Не удалось сохранить книгу');
        }
        $this->id = $book->id;
        $bookAuthors = [];
        foreach ($this->authors as $authorId) {
            $bookAuthors[] = [
                $book->id,
                $authorId
            ];
        }
        $db->createCommand()->batchInsert(BookAuthor::tableName(), ['book_id', 'author_id'], $bookAuthors)
            ->execute();
        $dbTransaction->commit();
        return true;
    }

    public function updateBook(): bool
    {
        if (empty($this->id)) {
            throw new ServerErrorHttpException('Для обновления книги должен быть указан ее идентификатор');
        }

        $db = \Yii::$app->db;
        $dbTransaction = $db->beginTransaction();
        $book = Book::findOne(['id' => $this->id]);
        $book->load($this->getAttributes(null, ['authors']));
        if (!$book->save() && empty($book->getErrors())) {
            throw new ServerErrorHttpException('Не удалось сохранить книгу');
        }
        if (empty($this->authors)) {
            BookAuthor::deleteAll(['book_id' => $book->id]);
            $dbTransaction->commit();
            return true;
        }
        $existAuthorsIds = ArrayHelper::getColumn($book->authors, 'id');
        $updatedAuthorsIds = array_map('intval', array_values($this->authors));
        $deletedAuthorsIds = array_diff($existAuthorsIds, $updatedAuthorsIds);
        $newAuthorsIds = array_diff($updatedAuthorsIds, $existAuthorsIds);
        $newBookAuthors = [];
        foreach ($newAuthorsIds as $authorId)
        {
            $newBookAuthors[] = [
                $book->id,
                $authorId
            ];
        }
        $db->createCommand()->batchInsert(
            BookAuthor::tableName(),
            ['book_id', 'author_id'],
            $newBookAuthors
        )->execute();
        if (!empty($deletedAuthorsIds)) {
            BookAuthor::deleteAll(
                ['book_id' => $book->id, 'author_id' => $deletedAuthorsIds]
            );
        }
        $dbTransaction->commit();
        return true;
    }

}