<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213225928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB21D2E1EE88');
        $this->addSql('DROP TABLE enclos');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, espace_id_id INT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, superficie INT NOT NULL, nb_animaux INT DEFAULT NULL, quarantaine TINYINT(1) NOT NULL, INDEX IDX_8CCECB21D2E1EE88 (espace_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB21D2E1EE88 FOREIGN KEY (espace_id_id) REFERENCES espace (id)');
    }
}
