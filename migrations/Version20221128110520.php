<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128110520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hairdresser_details (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, salon_id INT DEFAULT NULL, biography LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_94753DE4A76ED395 (user_id), UNIQUE INDEX UNIQ_94753DE44C91BDE4 (salon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hairdresser_details ADD CONSTRAINT FK_94753DE4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hairdresser_details ADD CONSTRAINT FK_94753DE44C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE salon CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser_details DROP FOREIGN KEY FK_94753DE4A76ED395');
        $this->addSql('ALTER TABLE hairdresser_details DROP FOREIGN KEY FK_94753DE44C91BDE4');
        $this->addSql('DROP TABLE hairdresser_details');
        $this->addSql('ALTER TABLE salon CHANGE description description VARCHAR(255) DEFAULT NULL');
    }
}
