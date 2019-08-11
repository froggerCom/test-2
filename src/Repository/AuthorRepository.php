<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\FetchMode;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AuthorRepository
 * @package App\Repository
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @param Author $author
     *
     * @return array
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getBooksIdByAuthor(Author $author): array
    {
        $sql = "
            SELECT book_id
            FROM authors_books
            WHERE author_id = ?
        ";

        $result = $this
            ->getEntityManager()
            ->getConnection()
            ->executeQuery(
                $sql,
                [
                    $author->getId(),
                ],
                [
                    \PDO::PARAM_INT
                ]
            )
            ->fetchAll(FetchMode::COLUMN);

        return $result;
    }
}