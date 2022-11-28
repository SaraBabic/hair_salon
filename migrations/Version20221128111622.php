<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128111622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salon_rating (id INT AUTO_INCREMENT NOT NULL, salon_id INT DEFAULT NULL, user_id INT DEFAULT NULL, rate SMALLINT NOT NULL, INDEX IDX_88EDDA4E4C91BDE4 (salon_id), INDEX IDX_88EDDA4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salon_rating ADD CONSTRAINT FK_88EDDA4E4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE salon_rating ADD CONSTRAINT FK_88EDDA4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salon_rating DROP FOREIGN KEY FK_88EDDA4E4C91BDE4');
        $this->addSql('ALTER TABLE salon_rating DROP FOREIGN KEY FK_88EDDA4EA76ED395');
        $this->addSql('DROP TABLE salon_rating');
    }
}
