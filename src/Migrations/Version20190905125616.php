<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190905125616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE labels ADD label_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D1021180BB389B FOREIGN KEY (label_status_id) REFERENCES label_status (id)');
        $this->addSql('CREATE INDEX IDX_B5D1021180BB389B ON labels (label_status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE labels DROP FOREIGN KEY FK_B5D1021180BB389B');
        $this->addSql('DROP INDEX IDX_B5D1021180BB389B ON labels');
        $this->addSql('ALTER TABLE labels DROP label_status_id');
    }
}
