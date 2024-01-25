<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124083707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(20) NOT NULL, INDEX IDX_1C52F95844F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pen (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, ref VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, pens_id INT DEFAULT NULL, name VARCHAR(20) NOT NULL, INDEX IDX_8CDE5729EFB54BC0 (pens_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F95844F5D008 FOREIGN KEY (brand_id) REFERENCES pen (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729EFB54BC0 FOREIGN KEY (pens_id) REFERENCES pen (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand DROP FOREIGN KEY FK_1C52F95844F5D008');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729EFB54BC0');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE pen');
        $this->addSql('DROP TABLE type');
    }
}
