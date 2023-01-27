<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127074023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD salon INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649822D70D5');
        $this->addSql('DROP INDEX UNIQ_8D93D649822D70D5 ON user');
        $this->addSql('ALTER TABLE user DROP hairdresser_details_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP salon');
        $this->addSql('ALTER TABLE user ADD hairdresser_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649822D70D5 FOREIGN KEY (hairdresser_details_id) REFERENCES hairdresser_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649822D70D5 ON user (hairdresser_details_id)');
    }
}
