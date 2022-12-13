<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213230929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclo ADD espace_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE enclo ADD CONSTRAINT FK_12DDA20BD2E1EE88 FOREIGN KEY (espace_id_id) REFERENCES espace (id)');
        $this->addSql('CREATE INDEX IDX_12DDA20BD2E1EE88 ON enclo (espace_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclo DROP FOREIGN KEY FK_12DDA20BD2E1EE88');
        $this->addSql('DROP INDEX IDX_12DDA20BD2E1EE88 ON enclo');
        $this->addSql('ALTER TABLE enclo DROP espace_id_id');
    }
}
