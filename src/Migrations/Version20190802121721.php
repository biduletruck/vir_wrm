<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802121721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, INDEX IDX_8244AA3ACFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agencies (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, user_id INT DEFAULT NULL, locations_id INT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, INDEX IDX_F65A4DC4CFFE9AD6 (orders_id), INDEX IDX_F65A4DC4A76ED395 (user_id), INDEX IDX_F65A4DC4ED775E23 (locations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3ACFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC4CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC4ED775E23 FOREIGN KEY (locations_id) REFERENCES locations (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE agencies');
    }
}
