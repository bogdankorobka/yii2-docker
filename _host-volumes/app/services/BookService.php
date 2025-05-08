<?php

declare(strict_types=1);

namespace app\services;

use app\models\Book;
use BookRepository;
use RuntimeException;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

final readonly class BookService
{
    public function __construct(
        private BookRepository $bookRepository
    ) {
    }

    /**
     * Создание "Книги"
     *
     * @param array $data
     * @return Book
     * @throws Exception
     */
    public function create(array $data): Book
    {
        $book = new Book();
        $book->load($data, '');
        if (!$book->save()) {
            throw new RuntimeException('Failed to create book');
        }
        return $book;
    }

    /**
     * Обновление "Книги" по идентификатору
     *
     * @param int $id
     * @param array $data
     * @return Book
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function update(int $id, array $data): Book
    {
        $book = $this->bookRepository->find($id);
        $book->load($data, '');
        if (!$book->save()) {
            throw new RuntimeException('Failed to update book');
        }
        return $book;
    }
}
