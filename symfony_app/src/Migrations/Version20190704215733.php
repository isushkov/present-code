<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704215733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reg_trans ADD show_on_home_page TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE budget CHANGE tih tih INT DEFAULT NULL, CHANGE hl hl INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hronos CHANGE tih_fct tih_fct INT DEFAULT NULL, CHANGE free_money free_money INT DEFAULT NULL, CHANGE hl hl INT DEFAULT NULL, CHANGE tih_teo tih_teo INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget CHANGE tih tih INT DEFAULT NULL, CHANGE hl hl INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hronos CHANGE tih_fct tih_fct INT DEFAULT NULL, CHANGE tih_teo tih_teo INT DEFAULT NULL, CHANGE free_money free_money INT DEFAULT NULL, CHANGE hl hl INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reg_trans DROP show_on_home_page');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
