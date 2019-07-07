<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706220733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail_order ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88D958C1A76ED395 ON detail_order (user_id)');
        $this->addSql('ALTER TABLE storages ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AEE41A5A76ED395 ON storages (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail_order DROP FOREIGN KEY FK_88D958C1A76ED395');
        $this->addSql('DROP INDEX UNIQ_88D958C1A76ED395 ON detail_order');
        $this->addSql('ALTER TABLE detail_order DROP user_id');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A5A76ED395');
        $this->addSql('DROP INDEX UNIQ_3AEE41A5A76ED395 ON storages');
        $this->addSql('ALTER TABLE storages DROP user_id');
    }
}
