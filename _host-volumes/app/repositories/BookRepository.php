<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Book;
use yii\web\NotFoundHttpException;

class BookRepository
{
    /**
     * Поиск "Книги" по идентификатору
     *
     * @param int $id
     * @return Book
     * @throws NotFoundHttpException
     */
    public function find(int $id): Book
    {
        if (!$book = Book::findOne($id)) {
            throw new NotFoundHttpException("Book not found");
        }
        return $book;
    }

    /**
     * Возвращает отсортированный по убыванию список лет и количества книг в каждом году
     *
     * @return array<Book>
     */
    public function countByYear(): array
    {
        return Book::find()
            ->select([
                'year' => new Expression('YEAR(published_at)'),
                'total' => new Expression('COUNT(*)')
            ])
            ->groupBy(new Expression('YEAR(published_at)'))
            ->orderBy(['year' => SORT_DESC])
            ->asArray()
            ->all();
    }
}
