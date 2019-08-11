<?php

namespace App\Controller;

use App\Entity\Book;
use App\Manager\BookManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController
 * @package App\Controller
 */
class BookController extends CommonController
{
    /**
     * @var BookManager
     */
    private $bookManager;

    /**
     * BookController constructor.
     *
     * @param BookManager $bookManager
     */
    public function __construct(BookManager $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    /**
     * @Route("/api/book", methods={"GET"})
     */
    public function getList(): JsonResponse
    {
        $data = $this
            ->bookManager
            ->getAll();

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/book", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createBook(Request $request): JsonResponse
    {
        $message = '';
        try {
            $request = $this->parseJson($request);
            $book = $this
                ->bookManager
                ->createBook($request);

            if (!$book instanceof Book) {
                $message = 'Something went wrong';
            } else {
                $this
                    ->bookManager
                    ->flush();
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if (!$message) {
            return new JsonResponse([], 201);
        }

        return new JsonResponse($message, 400);
    }

    /**
     * @Route("/api/book/{book}", methods={"GET"})
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function getBook(Book $book): JsonResponse
    {
        return new JsonResponse($book);
    }

    /**
     * @Route("/api/book/{book}", methods={"PATCH"})
     *
     * @param Book $book
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function editBook(Book $book, Request $request): JsonResponse
    {
        $message = '';
        try {
            $request = $this->parseJson($request);
            $this
                ->bookManager
                ->updateBook($book, $request);

            $this
                ->bookManager
                ->flush();
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if (!$message) {
            return new JsonResponse([]);
        }

        return new JsonResponse($message, 400);
    }
}