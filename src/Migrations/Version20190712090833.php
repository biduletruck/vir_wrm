<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190712090833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE storage_history DROP FOREIGN KEY FK_508643297B4184E3');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A58161305E');
        $this->addSql('ALTER TABLE detail_order DROP FOREIGN KEY FK_88D958C1333625D8');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEED3649E4C');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6BF700BD');
        $this->addSql('DROP TABLE detail_order');
        $this->addSql('DROP TABLE detail_order_type');
        $this->addSql('DROP TABLE return_type');
        $this->addSql('DROP TABLE status_order');
        $this->addSql('DROP TABLE storage_history');
        $this->addSql('DROP TABLE storages');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP INDEX UNIQ_E52FFDEED3649E4C ON orders');
        $this->addSql('DROP INDEX UNIQ_E52FFDEEA76ED395 ON orders');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE6BF700BD ON orders');
        $this->addSql('ALTER TABLE orders DROP return_type_id, DROP status_id, DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE detail_order (id INT AUTO_INCREMENT NOT NULL, order_type_id INT DEFAULT NULL, orders_id INT DEFAULT NULL, user_id INT DEFAULT NULL, number_detail VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_88D958C1CFFE9AD6 (orders_id), UNIQUE INDEX UNIQ_88D958C1333625D8 (order_type_id), UNIQUE INDEX UNIQ_88D958C1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE detail_order_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE return_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE status_order (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE storage_history (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, detail_order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, storage_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_5086432964D218E (location_id), UNIQUE INDEX UNIQ_50864329A76ED395 (user_id), UNIQUE INDEX UNIQ_508643297B4184E3 (detail_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE storages (id INT AUTO_INCREMENT NOT NULL, detail_order_number_id INT DEFAULT NULL, socket_id INT DEFAULT NULL, user_id INT DEFAULT NULL, storage_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_3AEE41A58161305E (detail_order_number_id), UNIQUE INDEX UNIQ_3AEE41A5A76ED395 (user_id), UNIQUE INDEX UNIQ_3AEE41A5D20E239C (socket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1333625D8 FOREIGN KEY (order_type_id) REFERENCES detail_order_type (id)');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE storage_history ADD CONSTRAINT FK_5086432964D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE storage_history ADD CONSTRAINT FK_508643297B4184E3 FOREIGN KEY (detail_order_id) REFERENCES detail_order (id)');
        $this->addSql('ALTER TABLE storage_history ADD CONSTRAINT FK_50864329A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A58161305E FOREIGN KEY (detail_order_number_id) REFERENCES detail_order (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A5D20E239C FOREIGN KEY (socket_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE orders ADD return_type_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6BF700BD FOREIGN KEY (status_id) REFERENCES status_order (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEED3649E4C FOREIGN KEY (return_type_id) REFERENCES return_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEED3649E4C ON orders (return_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEEA76ED395 ON orders (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE6BF700BD ON orders (status_id)');
    }
}
