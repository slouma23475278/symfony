<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415104322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clubs (IdClub INT AUTO_INCREMENT NOT NULL, NomClub VARCHAR(20) NOT NULL, FonctionClub VARCHAR(10) NOT NULL, DescriptionClub VARCHAR(10) NOT NULL, LogoClub LONGBLOB NOT NULL, TresorieClub DOUBLE PRECISION NOT NULL, LocalClub INT NOT NULL, NombreStudentClub INT NOT NULL, PRIMARY KEY(IdClub)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (IdEvent INT AUTO_INCREMENT NOT NULL, TypeEvent VARCHAR(255) NOT NULL, NomEvent VARCHAR(255) NOT NULL, Description VARCHAR(255) NOT NULL, TimeEventD DATETIME NOT NULL, TimeEventF DATETIME NOT NULL, LienFichier VARCHAR(255) NOT NULL, DateEvent VARCHAR(255) NOT NULL, IdClub INT DEFAULT NULL, IdLecture INT DEFAULT NULL, INDEX IDX_B26681ECCBF63DA (IdClub), INDEX IDX_B26681E532F9019 (IdLecture), PRIMARY KEY(IdEvent)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture (IdLecture INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(IdLecture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681ECCBF63DA FOREIGN KEY (IdClub) REFERENCES clubs (IdClub)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E532F9019 FOREIGN KEY (IdLecture) REFERENCES lecture (IdLecture)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681ECCBF63DA');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E532F9019');
        $this->addSql('DROP TABLE clubs');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE lecture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
