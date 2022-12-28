<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228135433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser_details DROP INDEX UNIQ_94753DE44C91BDE4, ADD INDEX IDX_94753DE44C91BDE4 (salon_id)');
        $this->addSql('ALTER TABLE salon_services CHANGE duration duration INT NOT NULL');
        $this->addSql('ALTER TABLE salon_working_hours CHANGE opening_at opening_at VARCHAR(255) NOT NULL, CHANGE closing_at closing_at VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser_details DROP INDEX IDX_94753DE44C91BDE4, ADD UNIQUE INDEX UNIQ_94753DE44C91BDE4 (salon_id)');
        $this->addSql('ALTER TABLE salon_services CHANGE duration duration SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE salon_working_hours CHANGE opening_at opening_at TIME NOT NULL, CHANGE closing_at closing_at TIME NOT NULL');
    }
}
