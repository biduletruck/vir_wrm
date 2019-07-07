<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706220452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail_order ADD orders_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_88D958C1CFFE9AD6 ON detail_order (orders_id)');
        $this->addSql('ALTER TABLE storages ADD socket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A5D20E239C FOREIGN KEY (socket_id) REFERENCES locations (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AEE41A5D20E239C ON storages (socket_id)');
        $this->addSql('ALTER TABLE locations ADD location VARCHAR(255) NOT NULL, ADD free_place TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail_order DROP FOREIGN KEY FK_88D958C1CFFE9AD6');
        $this->addSql('DROP INDEX IDX_88D958C1CFFE9AD6 ON detail_order');
        $this->addSql('ALTER TABLE detail_order DROP orders_id');
        $this->addSql('ALTER TABLE locations DROP location, DROP free_place');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A5D20E239C');
        $this->addSql('DROP INDEX UNIQ_3AEE41A5D20E239C ON storages');
        $this->addSql('ALTER TABLE storages DROP socket_id');
    }
}
