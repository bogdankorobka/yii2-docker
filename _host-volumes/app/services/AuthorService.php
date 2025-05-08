<?php

declare(strict_types=1);

namespace app\services;

use app\models\Author;
use DomainException;
use yii\db\Exception;

class AuthorService
{
    /**
     * Создание "Автора"
     *
     * @param string $name
     * @return Author
     * @throws Exception|DomainException
     */
    public function create(string $name): Author
    {
        $author = new Author(['name' => $name]);
        if (!$author->save()) {
            throw new DomainException('Failed to create author');
        }

        return $author;
    }
}
