<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190808081502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABACDEADB2A FOREIGN KEY (agency_id) REFERENCES agencies (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9CDEADB2A FOREIGN KEY (agency_id) REFERENCES agencies (id)');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D10211CFDC10B6 FOREIGN KEY (vir_local_number_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D102115CB2E05D FOREIGN KEY (login_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D1021164D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEECDEADB2A FOREIGN KEY (agency_id) REFERENCES agencies (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE1F2296BB FOREIGN KEY (order_back_id) REFERENCES order_back (id)');
        $this->addSql('ALTER TABLE product_listing ADD CONSTRAINT FK_1AD953648C26A5E8 FOREIGN KEY (order_number_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE product_listing ADD CONSTRAINT FK_1AD95364764EB525 FOREIGN KEY (family_product_id) REFERENCES family_product (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A54584665A FOREIGN KEY (product_id) REFERENCES product_listing (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A564D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE storages ADD CONSTRAINT FK_3AEE41A55CB2E05D FOREIGN KEY (login_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE labels DROP FOREIGN KEY FK_B5D10211CFDC10B6');
        $this->addSql('ALTER TABLE labels DROP FOREIGN KEY FK_B5D102115CB2E05D');
        $this->addSql('ALTER TABLE labels DROP FOREIGN KEY FK_B5D1021164D218E');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABACDEADB2A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE979B1AD6');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEECDEADB2A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE1F2296BB');
        $this->addSql('ALTER TABLE product_listing DROP FOREIGN KEY FK_1AD953648C26A5E8');
        $this->addSql('ALTER TABLE product_listing DROP FOREIGN KEY FK_1AD95364764EB525');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A54584665A');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A564D218E');
        $this->addSql('ALTER TABLE storages DROP FOREIGN KEY FK_3AEE41A55CB2E05D');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9CDEADB2A');
    }
}
