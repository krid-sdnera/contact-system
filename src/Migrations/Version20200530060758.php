<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530060758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE member_role (member_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(member_id, role_id))');
        $this->addSql('CREATE INDEX IDX_ABE1A6367597D3FE ON member_role (member_id)');
        $this->addSql('CREATE INDEX IDX_ABE1A636D60322AC ON member_role (role_id)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, address CLOB NOT NULL --(DC2Type:json)
        , phone_home VARCHAR(255) DEFAULT NULL, phone_mobile VARCHAR(255) DEFAULT NULL, phone_work VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, occupation VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP INDEX IDX_57698A6AD823E37A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__role AS SELECT id, section_id, name FROM role');
        $this->addSql('DROP TABLE role');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, section_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_57698A6AD823E37A FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO role (id, section_id, name) SELECT id, section_id, name FROM __temp__role');
        $this->addSql('DROP TABLE __temp__role');
        $this->addSql('CREATE INDEX IDX_57698A6AD823E37A ON role (section_id)');
        $this->addSql('ALTER TABLE member ADD COLUMN date_of_birth DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD COLUMN membership_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD COLUMN phone_home VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD COLUMN phone_mobile VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD COLUMN phone_work VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD COLUMN gender VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD COLUMN email VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__section AS SELECT id, name FROM section');
        $this->addSql('DROP TABLE section');
        $this->addSql('CREATE TABLE section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scout_group_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_2D737AEFE800F96A FOREIGN KEY (scout_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO section (id, name) SELECT id, name FROM __temp__section');
        $this->addSql('DROP TABLE __temp__section');
        $this->addSql('CREATE INDEX IDX_2D737AEFE800F96A ON section (scout_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE member_role');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TEMPORARY TABLE __temp__member AS SELECT id, firstname, lastname, nickname, address FROM member');
        $this->addSql('DROP TABLE member');
        $this->addSql('CREATE TABLE member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, address CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO member (id, firstname, lastname, nickname, address) SELECT id, firstname, lastname, nickname, address FROM __temp__member');
        $this->addSql('DROP TABLE __temp__member');
        $this->addSql('DROP INDEX IDX_57698A6AD823E37A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__role AS SELECT id, section_id, name FROM role');
        $this->addSql('DROP TABLE role');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, section_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO role (id, section_id, name) SELECT id, section_id, name FROM __temp__role');
        $this->addSql('DROP TABLE __temp__role');
        $this->addSql('CREATE INDEX IDX_57698A6AD823E37A ON role (section_id)');
        $this->addSql('DROP INDEX IDX_2D737AEFE800F96A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__section AS SELECT id, name FROM section');
        $this->addSql('DROP TABLE section');
        $this->addSql('CREATE TABLE section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO section (id, name) SELECT id, name FROM __temp__section');
        $this->addSql('DROP TABLE __temp__section');
    }
}
