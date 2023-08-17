<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817092643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE actor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE director_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE theater_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE actor (id INT NOT NULL, first_name TEXT NOT NULL, last_name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE director (id INT NOT NULL, first_name TEXT NOT NULL, last_name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, release_date DATE NOT NULL, synopsis TEXT NOT NULL, rating INT DEFAULT NULL, duration VARCHAR(255) NOT NULL, title TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie_movie_category (movie_id INT NOT NULL, movie_category_id INT NOT NULL, PRIMARY KEY(movie_id, movie_category_id))');
        $this->addSql('CREATE INDEX IDX_F9DC16648F93B6FC ON movie_movie_category (movie_id)');
        $this->addSql('CREATE INDEX IDX_F9DC16643DC01115 ON movie_movie_category (movie_category_id)');
        $this->addSql('CREATE TABLE movie_actor (movie_id INT NOT NULL, actor_id INT NOT NULL, PRIMARY KEY(movie_id, actor_id))');
        $this->addSql('CREATE INDEX IDX_3A374C658F93B6FC ON movie_actor (movie_id)');
        $this->addSql('CREATE INDEX IDX_3A374C6510DAF24A ON movie_actor (actor_id)');
        $this->addSql('CREATE TABLE movie_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie_session (id INT NOT NULL, theater_id INT NOT NULL, language VARCHAR(255) NOT NULL, room INT NOT NULL, beginning_hour INT NOT NULL, beginning_minute INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0D297FAD70E4479 ON movie_session (theater_id)');
        $this->addSql('CREATE TABLE theater (id INT NOT NULL, name TEXT NOT NULL, address TEXT NOT NULL, zip_code INT NOT NULL, city TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE movie_movie_category ADD CONSTRAINT FK_F9DC16648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_movie_category ADD CONSTRAINT FK_F9DC16643DC01115 FOREIGN KEY (movie_category_id) REFERENCES movie_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_actor ADD CONSTRAINT FK_3A374C658F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_actor ADD CONSTRAINT FK_3A374C6510DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_session ADD CONSTRAINT FK_F0D297FAD70E4479 FOREIGN KEY (theater_id) REFERENCES theater (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE actor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE director_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_session_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE theater_id_seq CASCADE');
        $this->addSql('ALTER TABLE movie_movie_category DROP CONSTRAINT FK_F9DC16648F93B6FC');
        $this->addSql('ALTER TABLE movie_movie_category DROP CONSTRAINT FK_F9DC16643DC01115');
        $this->addSql('ALTER TABLE movie_actor DROP CONSTRAINT FK_3A374C658F93B6FC');
        $this->addSql('ALTER TABLE movie_actor DROP CONSTRAINT FK_3A374C6510DAF24A');
        $this->addSql('ALTER TABLE movie_session DROP CONSTRAINT FK_F0D297FAD70E4479');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_movie_category');
        $this->addSql('DROP TABLE movie_actor');
        $this->addSql('DROP TABLE movie_category');
        $this->addSql('DROP TABLE movie_session');
        $this->addSql('DROP TABLE theater');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
