<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715123859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE labels (id INT AUTO_INCREMENT NOT NULL, vir_local_number_id INT NOT NULL, location_id INT DEFAULT NULL, login_id INT DEFAULT NULL, local_label VARCHAR(255) NOT NULL, INDEX IDX_B5D10211CFDC10B6 (vir_local_number_id), UNIQUE INDEX UNIQ_B5D1021164D218E (location_id), INDEX IDX_B5D102115CB2E05D (login_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D10211CFDC10B6 FOREIGN KEY (vir_local_number_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D1021164D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D102115CB2E05D FOREIGN KEY (login_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE labels');
    }
}
