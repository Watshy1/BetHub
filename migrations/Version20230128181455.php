<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128181455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE difficulty (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matche (id INT NOT NULL, player1_id INT NOT NULL, player2_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FCAD510C0990423 ON matche (player1_id)');
        $this->addSql('CREATE INDEX IDX_9FCAD510D22CABCD ON matche (player2_id)');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, country_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, track_record VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98197A65F92F3E70 ON player (country_id)');
        $this->addSql('CREATE TABLE score (id INT NOT NULL, matche_id INT NOT NULL, player_id INT NOT NULL, set1 INT NOT NULL, set2 INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32993751FD997C2B ON score (matche_id)');
        $this->addSql('CREATE INDEX IDX_3299375199E6F5DF ON score (player_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, difficulty_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, wallet INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649FCFA9DAE ON "user" (difficulty_id)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510C0990423 FOREIGN KEY (player1_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510D22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751FD997C2B FOREIGN KEY (matche_id) REFERENCES matche (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_3299375199E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulty (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD510C0990423');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD510D22CABCD');
        $this->addSql('ALTER TABLE player DROP CONSTRAINT FK_98197A65F92F3E70');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_32993751FD997C2B');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_3299375199E6F5DF');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649FCFA9DAE');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE difficulty');
        $this->addSql('DROP TABLE matche');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
