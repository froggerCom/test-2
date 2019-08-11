<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190811163819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, middle_name VARCHAR(50) NOT NULL, UNIQUE INDEX uidx_fio (first_name, last_name, middle_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authors_books (author_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_2DFDA3CBF675F31B (author_id), INDEX IDX_2DFDA3CB16A2B381 (book_id), PRIMARY KEY(author_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, year INT NOT NULL, isbn VARCHAR(50) NOT NULL, pages INT NOT NULL, image LONGBLOB DEFAULT NULL, UNIQUE INDEX uidx_title_year (title, year), UNIQUE INDEX uidx_isbn (isbn), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authors_books ADD CONSTRAINT FK_2DFDA3CBF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE authors_books ADD CONSTRAINT FK_2DFDA3CB16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE authors_books DROP FOREIGN KEY FK_2DFDA3CBF675F31B');
        $this->addSql('ALTER TABLE authors_books DROP FOREIGN KEY FK_2DFDA3CB16A2B381');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE authors_books');
        $this->addSql('DROP TABLE book');
    }
}
