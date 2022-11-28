<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128112034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salon_working_hours (id INT AUTO_INCREMENT NOT NULL, salon_id INT DEFAULT NULL, day SMALLINT NOT NULL, opening_at TIME NOT NULL, closing_at TIME NOT NULL, INDEX IDX_5ED5FDE14C91BDE4 (salon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salon_working_hours ADD CONSTRAINT FK_5ED5FDE14C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salon_working_hours DROP FOREIGN KEY FK_5ED5FDE14C91BDE4');
        $this->addSql('DROP TABLE salon_working_hours');
    }
}
