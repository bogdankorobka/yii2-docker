<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Author;
use yii\db\Expression;

final class AuthorRepository
{
    /**
     * Получение списка авторов, с наибольшим количеством книг
     *
     * @param int $limit
     * @return array<Author>
     */
    public function getTopAuthors(int $limit = 5): array
    {
        return Author::find()
            ->select(['author.*', 'books_count' => new Expression('COUNT(book.id)')])
            ->joinWith('books', false)
            ->groupBy('author.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit)
            ->asArray()
            ->all();
    }
}
