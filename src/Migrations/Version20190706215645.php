<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706215645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE return_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_order (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, return_type_id INT DEFAULT NULL, status_id INT DEFAULT NULL, user_id INT DEFAULT NULL, ordering_number VARCHAR(255) NOT NULL, vir_local_number VARCHAR(255) NOT NULL, customer_name VARCHAR(255) NOT NULL, date_entry DATETIME NOT NULL, delivry_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_E52FFDEED3649E4C (return_type_id), UNIQUE INDEX UNIQ_E52FFDEE6BF700BD (status_id), UNIQUE INDEX UNIQ_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_order (id INT AUTO_INCREMENT NOT NULL, order_type_id INT DEFAULT NULL, number_detail VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_88D958C1333625D8 (order_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_order_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storages (id INT AUTO_INCREMENT NOT NULL, detail_order_number_id INT DEFAULT NULL, storage_date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3AEE41A58161305E (detail_order_number_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, aisle VARCHAR(255) NOT NULL, floor INT NOT NULL, socket INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEED3649E4C FOREIGN KEY (return_type_id) REFERENCES return_type (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6BF700BD FOREIGN KEY (status_id) REFERENCES status_order (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE detail_order ADD CONSTRAINT FK_88D958C1333625D8 FOREIGN KEY (order_type_id) REFERENCES detail_order_type (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A58161305E FOREIGN KEY (detail_order_number_id) REFERENCES detail_order (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEED3649E4C');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6BF700BD');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A58161305E');
        $this->addSql('ALTER TABLE detail_order DROP FOREIGN KEY FK_88D958C1333625D8');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP TABLE return_type');
        $this->addSql('DROP TABLE status_order');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE detail_order');
        $this->addSql('DROP TABLE detail_order_type');
        $this->addSql('DROP TABLE storages');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE locations');
    }
}
