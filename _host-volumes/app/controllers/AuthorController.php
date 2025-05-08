<?php

declare(strict_types=1);

namespace app\controllers;

use app\repositories\AuthorRepository;
use app\services\AuthorService;
use DomainException;
use Psr\Log\LoggerInterface;
use Throwable;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class AuthorController extends Controller
{
    private AuthorService $authorService;
    private AuthorRepository $authorRepository;
    private LoggerInterface $logger;

    public function __construct(
        $id,
        $module,
        AuthorService $authorService,
        AuthorRepository $authorRepository,
        LoggerInterface $logger,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->authorService = $authorService;
        $this->authorRepository = $authorRepository;
        $this->logger = $logger;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionTop(): Response
    {
        try {
            $topAuthors = $this->authorRepository->getTopAuthors(10);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ServerErrorHttpException(500, 'Internal Server Error');
        }

        return $this->asJson($topAuthors);
    }

    /**
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionCreate(string $name): Response
    {
        try {
            $author = $this->authorService->create($name);
        } catch (DomainException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ServerErrorHttpException('Internal Server Error');
        }

        return $this->asJson($author);
    }
}
