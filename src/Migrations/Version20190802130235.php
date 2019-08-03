<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802130235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agencies DROP FOREIGN KEY FK_F65A4DC4A76ED395');
        $this->addSql('ALTER TABLE agencies DROP FOREIGN KEY FK_F65A4DC4CFFE9AD6');
        $this->addSql('ALTER TABLE agencies DROP FOREIGN KEY FK_F65A4DC4ED775E23');
        $this->addSql('DROP INDEX IDX_F65A4DC4A76ED395 ON agencies');
        $this->addSql('DROP INDEX IDX_F65A4DC4CFFE9AD6 ON agencies');
        $this->addSql('DROP INDEX IDX_F65A4DC4ED775E23 ON agencies');
        $this->addSql('ALTER TABLE agencies DROP orders_id, DROP user_id, DROP locations_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agencies ADD orders_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD locations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC4CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC4ED775E23 FOREIGN KEY (locations_id) REFERENCES locations (id)');
        $this->addSql('CREATE INDEX IDX_F65A4DC4A76ED395 ON agencies (user_id)');
        $this->addSql('CREATE INDEX IDX_F65A4DC4CFFE9AD6 ON agencies (orders_id)');
        $this->addSql('CREATE INDEX IDX_F65A4DC4ED775E23 ON agencies (locations_id)');
    }
}
