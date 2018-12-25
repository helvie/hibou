<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181218070522 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owl_prospect_information DROP FOREIGN KEY FK_710487E8D182060A');
        $this->addSql('CREATE TABLE owl_prospect (id INT AUTO_INCREMENT NOT NULL, prospect_information_id INT DEFAULT NULL, last_action_id INT DEFAULT NULL, next_action_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(254) NOT NULL, phone VARCHAR(255) DEFAULT NULL, quote_request TINYINT(1) NOT NULL, newsletter_request TINYINT(1) NOT NULL, informations_request TINYINT(1) NOT NULL, archived TINYINT(1) NOT NULL, last_action_date DATE NOT NULL, next_action_date DATE NOT NULL, applicant INT NOT NULL, information LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_3CD64B2BE7927C74 (email), UNIQUE INDEX UNIQ_3CD64B2B8B51E06C (prospect_information_id), INDEX IDX_3CD64B2B8AFD2F33 (last_action_id), INDEX IDX_3CD64B2BDAB82506 (next_action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owl_prospect ADD CONSTRAINT FK_3CD64B2B8B51E06C FOREIGN KEY (prospect_information_id) REFERENCES owl_prospect_information (id)');
        $this->addSql('ALTER TABLE owl_prospect ADD CONSTRAINT FK_3CD64B2B8AFD2F33 FOREIGN KEY (last_action_id) REFERENCES owl_prospect_last_action (id)');
        $this->addSql('ALTER TABLE owl_prospect ADD CONSTRAINT FK_3CD64B2BDAB82506 FOREIGN KEY (next_action_id) REFERENCES owl_prospect_next_action (id)');
        $this->addSql('DROP TABLE prospect');
        $this->addSql('ALTER TABLE owl_prospect_information DROP FOREIGN KEY FK_710487E8D182060A');
        $this->addSql('ALTER TABLE owl_prospect_information ADD CONSTRAINT FK_710487E8D182060A FOREIGN KEY (prospect_id) REFERENCES owl_prospect (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owl_prospect_information DROP FOREIGN KEY FK_710487E8D182060A');
        $this->addSql('CREATE TABLE prospect (id INT AUTO_INCREMENT NOT NULL, prospect_information_id INT DEFAULT NULL, last_action_id INT DEFAULT NULL, next_action_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, quote_request TINYINT(1) NOT NULL, newsletter_request TINYINT(1) NOT NULL, informations_request TINYINT(1) NOT NULL, archived TINYINT(1) NOT NULL, last_action_date DATE NOT NULL, next_action_date DATE NOT NULL, applicant INT NOT NULL, information LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX UNIQ_C9CE8C7DE7927C74 (email), UNIQUE INDEX UNIQ_C9CE8C7D8B51E06C (prospect_information_id), INDEX IDX_C9CE8C7D8AFD2F33 (last_action_id), INDEX IDX_C9CE8C7DDAB82506 (next_action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE owl_prospect');
        $this->addSql('ALTER TABLE owl_prospect_information DROP FOREIGN KEY FK_710487E8D182060A');
        $this->addSql('ALTER TABLE owl_prospect_information ADD CONSTRAINT FK_710487E8D182060A FOREIGN KEY (prospect_id) REFERENCES prospect (id)');
    }
}
