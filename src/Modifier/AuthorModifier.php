<?php

namespace App\Modifier;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AuthorModifier
 * @package App\Modifier
 */
class AuthorModifier implements ModifierInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AuthorModifier constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $field
     * @param $value
     * @param object $author
     *
     * @return null
     */
    public function modify(
        string $field,
        $value,
        object $author
    )
    {
        switch ($field) {
            case 'books':
                $newValue = [];
                if (is_array($value)) {
                    $currentAuthors = $this
                        ->entityManager
                        ->getRepository(Author::class)
                        ->getBooksIdByAuthor($author);
                    foreach ($value as $item) {
                        if (!in_array($item, $currentAuthors)) {
                            $book = $this
                                ->entityManager
                                ->getRepository(Book::class)
                                ->find($item);
                            if ($book instanceof Book) {
                                $newValue[] = $book;
                            }
                        }
                    }
                    $value = $newValue;
                } else {
                    $value = $newValue;
                }
                break;
        }

        return $value;
    }

}