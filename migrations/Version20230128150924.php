<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128150924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE countries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matches_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE players_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE countries (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matches (id INT NOT NULL, players1_id_id INT NOT NULL, players2_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62615BA18EB2AAC ON matches (players1_id_id)');
        $this->addSql('CREATE INDEX IDX_62615BA29033031 ON matches (players2_id_id)');
        $this->addSql('CREATE TABLE players (id INT NOT NULL, countries_id_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, track_record VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_264E43A675D39309 ON players (countries_id_id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA18EB2AAC FOREIGN KEY (players1_id_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA29033031 FOREIGN KEY (players2_id_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A675D39309 FOREIGN KEY (countries_id_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE countries_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matches_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE players_id_seq CASCADE');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BA18EB2AAC');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BA29033031');
        $this->addSql('ALTER TABLE players DROP CONSTRAINT FK_264E43A675D39309');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE players');
    }
}
