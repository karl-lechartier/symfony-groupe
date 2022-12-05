<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205203623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animaux (id INT AUTO_INCREMENT NOT NULL, numero_identification BIGINT NOT NULL, nom VARCHAR(50) DEFAULT NULL, date_naissance DATE DEFAULT NULL, date_arrivee DATE NOT NULL, date_depart DATE DEFAULT NULL, proprietaire SMALLINT NOT NULL, genre VARCHAR(50) NOT NULL, espece VARCHAR(50) NOT NULL, sterilise SMALLINT DEFAULT NULL, quarantaine SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animaux_enclos (animaux_id INT NOT NULL, enclos_id INT NOT NULL, INDEX IDX_9F2DCFDA9DAECAA (animaux_id), INDEX IDX_9F2DCFDB1C0859 (enclos_id), PRIMARY KEY(animaux_id, enclos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, espces_id_id INT NOT NULL, nom VARCHAR(50) DEFAULT NULL, superficie INT NOT NULL, animaux_max INT NOT NULL, quarantaine SMALLINT NOT NULL, INDEX IDX_8CCECB213E76667D (espces_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espaces (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, superficie INT NOT NULL, date_ouverture DATE DEFAULT NULL, date_fermeture DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animaux_enclos ADD CONSTRAINT FK_9F2DCFDA9DAECAA FOREIGN KEY (animaux_id) REFERENCES animaux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animaux_enclos ADD CONSTRAINT FK_9F2DCFDB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB213E76667D FOREIGN KEY (espces_id_id) REFERENCES espaces (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux_enclos DROP FOREIGN KEY FK_9F2DCFDA9DAECAA');
        $this->addSql('ALTER TABLE animaux_enclos DROP FOREIGN KEY FK_9F2DCFDB1C0859');
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB213E76667D');
        $this->addSql('DROP TABLE animaux');
        $this->addSql('DROP TABLE animaux_enclos');
        $this->addSql('DROP TABLE enclos');
        $this->addSql('DROP TABLE espaces');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
