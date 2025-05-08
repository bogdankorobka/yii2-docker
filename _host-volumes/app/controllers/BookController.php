<?php

declare(strict_types=1);

namespace app\controllers;

use app\repositories\BookRepository;
use app\services\BookService;
use DomainException;
use Psr\Log\LoggerInterface;
use Throwable;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class BookController extends Controller
{
    private BookService $bookService;
    private BookRepository $bookRepository;
    private LoggerInterface $logger;

    public function __construct(
        $id,
        $module,
        BookService $bookService,
        BookRepository $bookRepository,
        LoggerInterface $logger,
        $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->bookService = $bookService;
        $this->bookRepository = $bookRepository;
        $this->logger = $logger;
    }

    /**
     * Просмотр "Книги" по идентификатору
     *
     * @throws ServerErrorHttpException
     */
    public function actionIndex(int $id): Response
    {
        try {
            $book = $this->bookRepository->find($id);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ServerErrorHttpException('Book not found');
        }

        return $this->asJson($book);
    }

    /**
     * Создание "Книги"
     *
     * @throws ServerErrorHttpException
     * @throws BadRequestHttpException
     */
    public function actionCreate(array $params): Response
    {
        try {
            $book = $this->bookService->create($params);
        } catch (DomainException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ServerErrorHttpException('Internal Server Error');
        }

        return $this->asJson($book);
    }

    /**
     * Обновление "Книги" по идентификатору
     *
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(int $id, array $params): Response
    {
        try {
            $book = $this->bookService->update($id, $params);
        } catch (DomainException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ServerErrorHttpException('Internal Server Error');
        }

        return $this->asJson($book);
    }
}
