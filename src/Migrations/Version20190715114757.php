<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715114757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE storages (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, location_id INT DEFAULT NULL, login_id INT DEFAULT NULL, location_date DATETIME DEFAULT NULL, INDEX IDX_3AEE41A54584665A (product_id), INDEX IDX_3AEE41A564D218E (location_id), INDEX IDX_3AEE41A55CB2E05D (login_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A54584665A FOREIGN KEY (product_id) REFERENCES product_listing (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A564D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A55CB2E05D FOREIGN KEY (login_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE storages');
    }
}
