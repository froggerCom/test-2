<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\FetchMode;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class BookRepository
 * @package App\Repository
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * BookRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param Book $book
     *
     * @return array
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAuthorsIdByBook(Book $book): array
    {
        $sql = "
            SELECT author_id
            FROM authors_books
            WHERE book_id = ?
        ";

        $result = $this
            ->getEntityManager()
            ->getConnection()
            ->executeQuery(
                $sql,
                [
                    $book->getId(),
                ],
                [
                    \PDO::PARAM_INT
                ]
            )
            ->fetchAll(FetchMode::COLUMN);

        return $result;
    }
}