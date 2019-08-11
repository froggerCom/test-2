<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Author
 *
 * @ORM\Table(name="author",
 *       uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uidx_fio", columns={"first_name", "last_name", "middle_name"})
 *       }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=50, nullable=false)
     */
    private $middleName;

    /**
     * @var ArrayCollection|Book[]
     *
     * @ORM\ManyToMany(targetEntity="Book", inversedBy="authors", cascade={"persist","remove"})
     * @ORM\JoinTable(name="authors_books")
     */
    private $books;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Author
     */
    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName(string $firstName): Author
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName(string $lastName): Author
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return Author
     */
    public function setMiddleName(string $middleName): Author
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @return Book[]|ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param Book[]|ArrayCollection $books
     * @return Author
     */
    public function setBooks($books)
    {
        $this->books = $books;
        return $this;
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function addBook(Book $book)
    {
        $this->books[] = $book;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $books = [];
        /** @var Book $item */
        foreach ($this->books as $item) {
            $books[] = $item->getTitle();
        }

        return array(
            'id' => $this->id,
            'fio' => $this->getFio(),
            'books' => $books,
        );
    }

    /**
     * @return string
     */
    public function getFio(): string
    {
        return $this->firstName . ' ' .
            substr($this->lastName, 0, 1) . '.' .
            substr($this->middleName, 0, 1) . '.';
    }
}