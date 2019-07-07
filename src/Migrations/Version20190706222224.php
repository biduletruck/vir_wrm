<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706222224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE connection_history (id INT AUTO_INCREMENT NOT NULL, connexion_date DATETIME NOT NULL, ip_adress VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, connection TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storage_history (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, detail_order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, storage_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_5086432964D218E (location_id), UNIQUE INDEX UNIQ_508643297B4184E3 (detail_order_id), UNIQUE INDEX UNIQ_50864329A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE storage_history ADD CONSTRAINT FK_5086432964D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE storage_history ADD CONSTRAINT FK_508643297B4184E3 FOREIGN KEY (detail_order_id) REFERENCES detail_order (id)');
        $this->addSql('ALTER TABLE storage_history ADD CONSTRAINT FK_50864329A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE connection_history');
        $this->addSql('DROP TABLE storage_history');
    }
}
