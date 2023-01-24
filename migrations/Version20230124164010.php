<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124164010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hairdresser_details (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, salon_id INT DEFAULT NULL, biography LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_94753DE4A76ED395 (user_id), INDEX IDX_94753DE44C91BDE4 (salon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, device_type VARCHAR(255) NOT NULL, user_agent VARCHAR(255) NOT NULL, ip_address VARCHAR(255) NOT NULL, continent VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F08FC65CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, hairdresser_id INT DEFAULT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_42C849559395C3F3 (customer_id), INDEX IDX_42C84955696F8EFF (hairdresser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_services (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, service_id INT DEFAULT NULL, INDEX IDX_EE87037DB83297E7 (reservation_id), INDEX IDX_EE87037DED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salon (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image_path VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_F268F4177E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salon_rating (id INT AUTO_INCREMENT NOT NULL, salon_id INT DEFAULT NULL, user_id INT DEFAULT NULL, rate SMALLINT NOT NULL, INDEX IDX_88EDDA4E4C91BDE4 (salon_id), INDEX IDX_88EDDA4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salon_services (id INT AUTO_INCREMENT NOT NULL, salon_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, duration INT NOT NULL, INDEX IDX_E712B914C91BDE4 (salon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salon_working_hours (id INT AUTO_INCREMENT NOT NULL, salon_id INT DEFAULT NULL, day SMALLINT NOT NULL, opening_at VARCHAR(255) DEFAULT NULL, closing_at VARCHAR(255) DEFAULT NULL, INDEX IDX_5ED5FDE14C91BDE4 (salon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, is_banned TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hairdresser_details ADD CONSTRAINT FK_94753DE4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hairdresser_details ADD CONSTRAINT FK_94753DE44C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955696F8EFF FOREIGN KEY (hairdresser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation_services ADD CONSTRAINT FK_EE87037DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation_services ADD CONSTRAINT FK_EE87037DED5CA9E6 FOREIGN KEY (service_id) REFERENCES salon_services (id)');
        $this->addSql('ALTER TABLE salon ADD CONSTRAINT FK_F268F4177E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE salon_rating ADD CONSTRAINT FK_88EDDA4E4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE salon_rating ADD CONSTRAINT FK_88EDDA4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE salon_services ADD CONSTRAINT FK_E712B914C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE salon_working_hours ADD CONSTRAINT FK_5ED5FDE14C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser_details DROP FOREIGN KEY FK_94753DE4A76ED395');
        $this->addSql('ALTER TABLE hairdresser_details DROP FOREIGN KEY FK_94753DE44C91BDE4');
        $this->addSql('ALTER TABLE logs DROP FOREIGN KEY FK_F08FC65CA76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559395C3F3');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955696F8EFF');
        $this->addSql('ALTER TABLE reservation_services DROP FOREIGN KEY FK_EE87037DB83297E7');
        $this->addSql('ALTER TABLE reservation_services DROP FOREIGN KEY FK_EE87037DED5CA9E6');
        $this->addSql('ALTER TABLE salon DROP FOREIGN KEY FK_F268F4177E3C61F9');
        $this->addSql('ALTER TABLE salon_rating DROP FOREIGN KEY FK_88EDDA4E4C91BDE4');
        $this->addSql('ALTER TABLE salon_rating DROP FOREIGN KEY FK_88EDDA4EA76ED395');
        $this->addSql('ALTER TABLE salon_services DROP FOREIGN KEY FK_E712B914C91BDE4');
        $this->addSql('ALTER TABLE salon_working_hours DROP FOREIGN KEY FK_5ED5FDE14C91BDE4');
        $this->addSql('DROP TABLE hairdresser_details');
        $this->addSql('DROP TABLE logs');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_services');
        $this->addSql('DROP TABLE salon');
        $this->addSql('DROP TABLE salon_rating');
        $this->addSql('DROP TABLE salon_services');
        $this->addSql('DROP TABLE salon_working_hours');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
