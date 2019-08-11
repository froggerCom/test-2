<?php


namespace App\Manager;

use App\Entity\Author;
use App\Entity\Book;
use App\Modifier\BookModifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookManager
 * @package App\Manager
 */
class BookManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RequestManager
     */
    private $requestManager;

    /**
     * @var BookModifier
     */
    private $bookModifier;

    /**
     * BookController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param RequestManager $requestManager
     * @param BookModifier $bookModifier
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestManager $requestManager,
        BookModifier $bookModifier
    )
    {
        $this->entityManager = $entityManager;
        $this->requestManager = $requestManager;
        $this->bookModifier = $bookModifier;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = $this
            ->entityManager
            ->getRepository(Book::class)
            ->findAll();

        return $result;
    }

    /**
     * @param Request $request
     *
     * @return Book
     *
     * @throws \ReflectionException
     */
    public function createBook(Request $request): Book
    {
        $book = new Book();
        $this
            ->requestManager
            ->parsePostDataIntoEntity(
                $request,
                $book,
                $this->bookModifier
            );
        $this
            ->entityManager
            ->persist($book);

        return $book;
    }

    public function flush(): void
    {
        $this
            ->entityManager
            ->flush();
    }

    /**
     * @param Book $book
     * @param Request $request
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function updateBook(Book $book, Request $request): void
    {
        $this
            ->requestManager
            ->parsePostDataIntoEntity(
                $request,
                $book,
                $this->bookModifier
            );
    }
}