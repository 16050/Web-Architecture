<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031121046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gear ADD sport_id INT NOT NULL, ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539BAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B44539BAC78BCF8 ON gear (sport_id)');
        $this->addSql('CREATE INDEX IDX_B44539B12469DE2 ON gear (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gear DROP FOREIGN KEY FK_B44539B12469DE2');
        $this->addSql('ALTER TABLE gear DROP FOREIGN KEY FK_B44539BAC78BCF8');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP INDEX IDX_B44539BAC78BCF8 ON gear');
        $this->addSql('DROP INDEX IDX_B44539B12469DE2 ON gear');
        $this->addSql('ALTER TABLE gear DROP sport_id, DROP category_id');
    }
}
