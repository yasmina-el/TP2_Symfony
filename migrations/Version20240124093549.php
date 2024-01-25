<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124093549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pen_color (pen_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_8844BCAA9CBC84D (pen_id), INDEX IDX_8844BCA7ADA1FB5 (color_id), PRIMARY KEY(pen_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pen_color ADD CONSTRAINT FK_8844BCAA9CBC84D FOREIGN KEY (pen_id) REFERENCES pen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pen_color ADD CONSTRAINT FK_8844BCA7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand DROP FOREIGN KEY FK_1C52F95844F5D008');
        $this->addSql('DROP INDEX IDX_1C52F95844F5D008 ON brand');
        $this->addSql('ALTER TABLE brand DROP brand_id, CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE pen ADD type_id INT NOT NULL, ADD material_id INT NOT NULL, ADD brand_id INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE pen ADD CONSTRAINT FK_193062FFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE pen ADD CONSTRAINT FK_193062FFE308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE pen ADD CONSTRAINT FK_193062FF44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_193062FF146F3EA3 ON pen (ref)');
        $this->addSql('CREATE INDEX IDX_193062FFC54C8C93 ON pen (type_id)');
        $this->addSql('CREATE INDEX IDX_193062FFE308AC6F ON pen (material_id)');
        $this->addSql('CREATE INDEX IDX_193062FF44F5D008 ON pen (brand_id)');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729EFB54BC0');
        $this->addSql('DROP INDEX IDX_8CDE5729EFB54BC0 ON type');
        $this->addSql('ALTER TABLE type DROP pens_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pen_color DROP FOREIGN KEY FK_8844BCAA9CBC84D');
        $this->addSql('ALTER TABLE pen_color DROP FOREIGN KEY FK_8844BCA7ADA1FB5');
        $this->addSql('DROP TABLE pen_color');
        $this->addSql('ALTER TABLE brand ADD brand_id INT DEFAULT NULL, CHANGE name name VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F95844F5D008 FOREIGN KEY (brand_id) REFERENCES pen (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1C52F95844F5D008 ON brand (brand_id)');
        $this->addSql('ALTER TABLE pen DROP FOREIGN KEY FK_193062FFC54C8C93');
        $this->addSql('ALTER TABLE pen DROP FOREIGN KEY FK_193062FFE308AC6F');
        $this->addSql('ALTER TABLE pen DROP FOREIGN KEY FK_193062FF44F5D008');
        $this->addSql('DROP INDEX UNIQ_193062FF146F3EA3 ON pen');
        $this->addSql('DROP INDEX IDX_193062FFC54C8C93 ON pen');
        $this->addSql('DROP INDEX IDX_193062FFE308AC6F ON pen');
        $this->addSql('DROP INDEX IDX_193062FF44F5D008 ON pen');
        $this->addSql('ALTER TABLE pen DROP type_id, DROP material_id, DROP brand_id, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE type ADD pens_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729EFB54BC0 FOREIGN KEY (pens_id) REFERENCES pen (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8CDE5729EFB54BC0 ON type (pens_id)');
    }
}
