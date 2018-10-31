<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181028214211 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE owl_comment (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, author VARCHAR(30) NOT NULL, date DATE NOT NULL, text VARCHAR(3000) NOT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_8377533B7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owl_commentResponse (id INT AUTO_INCREMENT NOT NULL, comment_id INT DEFAULT NULL, author VARCHAR(30) NOT NULL, date DATE NOT NULL, text VARCHAR(3000) NOT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_EDF62297F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owl_comment ADD CONSTRAINT FK_8377533B7294869C FOREIGN KEY (article_id) REFERENCES owl_article (id)');
        $this->addSql('ALTER TABLE owl_commentResponse ADD CONSTRAINT FK_EDF62297F8697D13 FOREIGN KEY (comment_id) REFERENCES owl_comment (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owl_commentResponse DROP FOREIGN KEY FK_EDF62297F8697D13');
        $this->addSql('DROP TABLE owl_comment');
        $this->addSql('DROP TABLE owl_commentResponse');
    }
}
