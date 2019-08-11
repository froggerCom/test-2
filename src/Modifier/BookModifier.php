<?php

namespace App\Modifier;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BookModifier
 * @package App\Modifier
 */
class BookModifier implements ModifierInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * BookModifier constructor.
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
     * @param object $book
     *
     * @return null
     */
    public function modify(
        string $field,
        $value,
        object $book
    )
    {
        switch ($field) {
            case 'authors':
                $newValue = [];
                if (is_array($value)) {
                    $currentAuthors = $this
                        ->entityManager
                        ->getRepository(Book::class)
                        ->getAuthorsIdByBook($book);
                    foreach ($value as $item) {
                        if (!in_array($item, $currentAuthors)) {
                            $author = $this
                                ->entityManager
                                ->getRepository(Author::class)
                                ->find($item);
                            if ($author instanceof Author) {
                                $author->addBook($book);
                                $newValue[] = $author;
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