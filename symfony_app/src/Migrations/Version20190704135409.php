<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704135409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tih INT DEFAULT NULL, hl INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE hronos CHANGE tih_fct tih_fct INT DEFAULT NULL, CHANGE free_money free_money INT DEFAULT NULL, CHANGE hl hl INT DEFAULT NULL, CHANGE tih_teo tih_teo INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE budget');
        $this->addSql('ALTER TABLE hronos CHANGE tih_fct tih_fct INT DEFAULT NULL, CHANGE tih_teo tih_teo INT DEFAULT NULL, CHANGE free_money free_money INT DEFAULT NULL, CHANGE hl hl INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
