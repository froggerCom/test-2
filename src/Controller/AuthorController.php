<?php

namespace App\Controller;

use App\Entity\Author;
use App\Manager\AuthorManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorController
 * @package App\Controller
 */
class AuthorController extends CommonController
{
    /**
     * @var AuthorManager
     */
    private $authorManager;

    /**
     * AuthorController constructor.
     * @param AuthorManager $authorManager
     */
    public function __construct(AuthorManager $authorManager)
    {
        $this->authorManager = $authorManager;
    }

    /**
     * @Route("/api/author", methods={"GET"})
     */
    public function getList(): JsonResponse
    {
        $data = $this
            ->authorManager
            ->getAll();

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/author", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAuthor(Request $request): JsonResponse
    {
        $message = '';
        try {
            $request = $this->parseJson($request);
            $author = $this
                ->authorManager
                ->createAuthor($request);

            if (!$author instanceof Author) {
                $message = 'Something went wrong';
            } else {
                $this
                    ->authorManager
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
     * @Route("/api/author/{author}", methods={"GET"})
     *
     * @param Author $author
     * @return JsonResponse
     */
    public function getAuthor(Author $author): JsonResponse
    {
        return new JsonResponse($author);
    }

    /**
     * @Route("/api/author/{author}", methods={"PATCH"})
     *
     * @param Author $author
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function editAuthor(Author $author, Request $request): JsonResponse
    {
        $message = '';
        try {
            $request = $this->parseJson($request);
            $this
                ->authorManager
                ->updateAuthor($author, $request);

            $this
                ->authorManager
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