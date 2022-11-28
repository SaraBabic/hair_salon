<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128114025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_services (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, service_id INT DEFAULT NULL, INDEX IDX_EE87037DB83297E7 (reservation_id), INDEX IDX_EE87037DED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_services ADD CONSTRAINT FK_EE87037DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation_services ADD CONSTRAINT FK_EE87037DED5CA9E6 FOREIGN KEY (service_id) REFERENCES salon_services (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_services DROP FOREIGN KEY FK_EE87037DB83297E7');
        $this->addSql('ALTER TABLE reservation_services DROP FOREIGN KEY FK_EE87037DED5CA9E6');
        $this->addSql('DROP TABLE reservation_services');
    }
}
