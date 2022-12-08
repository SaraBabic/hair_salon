<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221208190354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE logs (id_log INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, device_type VARCHAR(255) NOT NULL, user_agent VARCHAR(255) NOT NULL, ip_address VARCHAR(255) NOT NULL, continent VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F08FC65CA76ED395 (user_id), PRIMARY KEY(id_log)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logs DROP FOREIGN KEY FK_F08FC65CA76ED395');
        $this->addSql('DROP TABLE logs');
    }
}
