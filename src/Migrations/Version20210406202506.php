<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406202506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_service CHANGE service service_id INT NOT NULL');
        $this->addSql('ALTER TABLE booking_service ADD CONSTRAINT FK_BB23DFF2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_BB23DFF2ED5CA9E6 ON booking_service (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_service DROP FOREIGN KEY FK_BB23DFF2ED5CA9E6');
        $this->addSql('DROP INDEX IDX_BB23DFF2ED5CA9E6 ON booking_service');
        $this->addSql('ALTER TABLE booking_service CHANGE service_id service INT NOT NULL');
    }
}
