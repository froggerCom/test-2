<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="book",
 *       uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uidx_title_year", columns={"title", "year"}),
 *          @ORM\UniqueConstraint(name="uidx_isbn", columns={"isbn"}),
 *       }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book implements \JsonSerializable
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=50, nullable=false)
     */
    private $isbn;

    /**
     * @var int
     *
     * @ORM\Column(name="pages", type="integer", nullable=false)
     */
    private $pages;

    /**
     * @var ArrayCollection|Author[]
     *
     * @ORM\ManyToMany(targetEntity="Author", mappedBy="books", cascade={"persist","remove"})
     */
    private $authors;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="blob", nullable=true)
     */
    private $image;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->authors = new ArrayCollection();
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
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle(string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Book
     */
    public function setYear(int $year): Book
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     * @return Book
     */
    public function setPages(int $pages): Book
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return Author[]|ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param Author[]|ArrayCollection $authors
     * @return Book
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @param Author $author
     * @return $this
     */
    public function addAuthor(Author $author)
    {
        $author->addBook($this);
        $this->authors[] = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Book
     */
    public function setImage(string $image): Book
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $authors = [];
        /** @var Author $item */
        foreach ($this->authors as $item) {
            $fio = $item->getFio();
            $authors[] = $fio;
        }

        return array(
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'isbn' => $this->isbn,
            'pages' => $this->pages,
            'image' => $this->image,
            'authors' => $authors
        );
    }
}