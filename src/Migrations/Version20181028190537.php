<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181028190537 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE owlArticle (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, author VARCHAR(30) NOT NULL, date DATE NOT NULL, update_date DATE NOT NULL, category VARCHAR(100) NOT NULL, text VARCHAR(3000) NOT NULL, visible TINYINT(1) NOT NULL, valid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE owl_article');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE owl_article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, author VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, date DATE NOT NULL, update_date DATE NOT NULL, category VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, visible TINYINT(1) NOT NULL, valid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE owlArticle');
    }
}
