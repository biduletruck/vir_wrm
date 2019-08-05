<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190805154803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users_agencies');
        $this->addSql('ALTER TABLE users ADD agency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9CDEADB2A FOREIGN KEY (agency_id) REFERENCES agencies (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9CDEADB2A ON users (agency_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users_agencies (users_id INT NOT NULL, agencies_id INT NOT NULL, INDEX IDX_8D1B661E67B3B43D (users_id), INDEX IDX_8D1B661E3E8E72F8 (agencies_id), PRIMARY KEY(users_id, agencies_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_agencies ADD CONSTRAINT FK_8D1B661E3E8E72F8 FOREIGN KEY (agencies_id) REFERENCES agencies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_agencies ADD CONSTRAINT FK_8D1B661E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9CDEADB2A');
        $this->addSql('DROP INDEX IDX_1483A5E9CDEADB2A ON users');
        $this->addSql('ALTER TABLE users DROP agency_id');
    }
}
