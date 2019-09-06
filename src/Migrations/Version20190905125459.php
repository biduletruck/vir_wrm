<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190905125459 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE label_status DROP FOREIGN KEY FK_9C2A56AD80BB389B');
        $this->addSql('DROP INDEX IDX_9C2A56AD80BB389B ON label_status');
        $this->addSql('ALTER TABLE label_status DROP label_status_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE label_status ADD label_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE label_status ADD CONSTRAINT FK_9C2A56AD80BB389B FOREIGN KEY (label_status_id) REFERENCES labels (id)');
        $this->addSql('CREATE INDEX IDX_9C2A56AD80BB389B ON label_status (label_status_id)');
    }
}
