<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802132003 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users_agencies (users_id INT NOT NULL, agencies_id INT NOT NULL, INDEX IDX_8D1B661E67B3B43D (users_id), INDEX IDX_8D1B661E3E8E72F8 (agencies_id), PRIMARY KEY(users_id, agencies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_agencies ADD CONSTRAINT FK_8D1B661E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_agencies ADD CONSTRAINT FK_8D1B661E3E8E72F8 FOREIGN KEY (agencies_id) REFERENCES agencies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agencies DROP FOREIGN KEY FK_F65A4DC467B3B43D');
        $this->addSql('DROP INDEX IDX_F65A4DC467B3B43D ON agencies');
        $this->addSql('ALTER TABLE agencies DROP users_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users_agencies');
        $this->addSql('ALTER TABLE agencies ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC467B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_F65A4DC467B3B43D ON agencies (users_id)');
    }
}
