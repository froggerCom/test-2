<?php


namespace App\Manager;

use App\Entity\Author;
use App\Modifier\AuthorModifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorManager
 * @package App\Manager
 */
class AuthorManager
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
     * @var AuthorModifier
     */
    private $authorModifier;

    /**
     * AuthorController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param RequestManager $requestManager
     * @param AuthorModifier $authorModifier
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestManager $requestManager,
        AuthorModifier $authorModifier
    )
    {
        $this->entityManager = $entityManager;
        $this->requestManager = $requestManager;
        $this->authorModifier = $authorModifier;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = $this
            ->entityManager
            ->getRepository(Author::class)
            ->findAll();

        return $result;
    }

    /**
     * @param Request $request
     *
     * @return Author
     *
     * @throws \ReflectionException
     */
    public function createAuthor(Request $request): Author
    {
        $author = new Author();
        $this
            ->requestManager
            ->parsePostDataIntoEntity(
                $request,
                $author,
                $this->authorModifier
            );
        $this
            ->entityManager
            ->persist($author);

        return $author;
    }

    public function flush(): void
    {
        $this
            ->entityManager
            ->flush();
    }

    /**
     * @param Author $author
     * @param Request $request
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function updateAuthor(Author $author, Request $request): void
    {
        $this
            ->requestManager
            ->parsePostDataIntoEntity(
                $request,
                $author,
                $this->authorModifier
            );
        $this
            ->entityManager
            ->persist($author);
    }
}