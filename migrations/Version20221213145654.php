<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213145654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB21D2E1EE88');
        $this->addSql('DROP INDEX IDX_8CCECB21D2E1EE88 ON enclos');
        $this->addSql('ALTER TABLE enclos DROP espace_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclos ADD espace_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB21D2E1EE88 FOREIGN KEY (espace_id_id) REFERENCES espace (id)');
        $this->addSql('CREATE INDEX IDX_8CCECB21D2E1EE88 ON enclos (espace_id_id)');
    }
}
