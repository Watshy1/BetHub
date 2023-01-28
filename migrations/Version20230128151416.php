<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128151416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE scores_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE scores (id INT NOT NULL, matches_id_id INT NOT NULL, players_id_id INT NOT NULL, set1 INT NOT NULL, set2 INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_750375E67F9D67A ON scores (matches_id_id)');
        $this->addSql('CREATE INDEX IDX_750375E6261B7FD ON scores (players_id_id)');
        $this->addSql('ALTER TABLE scores ADD CONSTRAINT FK_750375E67F9D67A FOREIGN KEY (matches_id_id) REFERENCES matches (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scores ADD CONSTRAINT FK_750375E6261B7FD FOREIGN KEY (players_id_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE scores_id_seq CASCADE');
        $this->addSql('ALTER TABLE scores DROP CONSTRAINT FK_750375E67F9D67A');
        $this->addSql('ALTER TABLE scores DROP CONSTRAINT FK_750375E6261B7FD');
        $this->addSql('DROP TABLE scores');
    }
}
