<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617110754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_57698A6AD823E37A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__role AS SELECT id, section_id, name FROM role');
        $this->addSql('DROP TABLE role');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, section_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_57698A6AD823E37A FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO role (id, section_id, name) SELECT id, section_id, name FROM __temp__role');
        $this->addSql('DROP TABLE __temp__role');
        $this->addSql('CREATE INDEX IDX_57698A6AD823E37A ON role (section_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__member AS SELECT id, membership_number, firstname, lastname, nickname, date_of_birth, gender, address, phone_home, phone_mobile, phone_work, email, state, management_state, expiry, overrides FROM member');
        $this->addSql('DROP TABLE member');
        $this->addSql('CREATE TABLE member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membership_number VARCHAR(255) DEFAULT NULL COLLATE BINARY, firstname VARCHAR(255) NOT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, nickname VARCHAR(255) NOT NULL COLLATE BINARY, date_of_birth DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL COLLATE BINARY, address CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , phone_home VARCHAR(255) DEFAULT NULL COLLATE BINARY, phone_mobile VARCHAR(255) DEFAULT NULL COLLATE BINARY, phone_work VARCHAR(255) DEFAULT NULL COLLATE BINARY, email VARCHAR(255) DEFAULT NULL COLLATE BINARY, state VARCHAR(255) DEFAULT \'enabled\' NOT NULL COLLATE BINARY, management_state VARCHAR(255) DEFAULT \'unmanaged\' NOT NULL COLLATE BINARY, expiry DATE DEFAULT NULL, overrides CLOB DEFAULT \'{}\' NOT NULL --(DC2Type:json)
        , school_name VARCHAR(255) DEFAULT NULL, school_year_level VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO member (id, membership_number, firstname, lastname, nickname, date_of_birth, gender, address, phone_home, phone_mobile, phone_work, email, state, management_state, expiry, overrides) SELECT id, membership_number, firstname, lastname, nickname, date_of_birth, gender, address, phone_home, phone_mobile, phone_work, email, state, management_state, expiry, overrides FROM __temp__member');
        $this->addSql('DROP TABLE __temp__member');
        $this->addSql('DROP INDEX IDX_2D737AEFE800F96A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__section AS SELECT id, scout_group_id, name FROM section');
        $this->addSql('DROP TABLE section');
        $this->addSql('CREATE TABLE section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scout_group_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_2D737AEFE800F96A FOREIGN KEY (scout_group_id) REFERENCES scout_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO section (id, scout_group_id, name) SELECT id, scout_group_id, name FROM __temp__section');
        $this->addSql('DROP TABLE __temp__section');
        $this->addSql('CREATE INDEX IDX_2D737AEFE800F96A ON section (scout_group_id)');
        $this->addSql('DROP INDEX IDX_4C62E6387597D3FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, member_id, firstname, nickname, lastname, address, phone_home, phone_mobile, phone_work, email, occupation, relationship, primary_contact, state, management_state, expiry, overrides FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, nickname VARCHAR(255) DEFAULT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, address CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , phone_home VARCHAR(255) DEFAULT NULL COLLATE BINARY, phone_mobile VARCHAR(255) DEFAULT NULL COLLATE BINARY, phone_work VARCHAR(255) DEFAULT NULL COLLATE BINARY, email VARCHAR(255) DEFAULT NULL COLLATE BINARY, occupation VARCHAR(255) DEFAULT NULL COLLATE BINARY, relationship VARCHAR(255) DEFAULT NULL COLLATE BINARY, primary_contact BOOLEAN NOT NULL, state VARCHAR(255) DEFAULT \'enabled\' NOT NULL COLLATE BINARY, management_state VARCHAR(255) DEFAULT \'unmanaged\' NOT NULL COLLATE BINARY, expiry DATE DEFAULT NULL, overrides CLOB DEFAULT \'{}\' NOT NULL COLLATE BINARY --(DC2Type:json)
        , parent_id INTEGER DEFAULT NULL, CONSTRAINT FK_4C62E6387597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contact (id, member_id, firstname, nickname, lastname, address, phone_home, phone_mobile, phone_work, email, occupation, relationship, primary_contact, state, management_state, expiry, overrides) SELECT id, member_id, firstname, nickname, lastname, address, phone_home, phone_mobile, phone_work, email, occupation, relationship, primary_contact, state, management_state, expiry, overrides FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE INDEX IDX_4C62E6387597D3FE ON contact (member_id)');
        $this->addSql('DROP INDEX IDX_ABE1A636D60322AC');
        $this->addSql('DROP INDEX IDX_ABE1A6367597D3FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__member_role AS SELECT member_id, role_id, state, management_state, expiry FROM member_role');
        $this->addSql('DROP TABLE member_role');
        $this->addSql('CREATE TABLE member_role (member_id INTEGER NOT NULL, role_id INTEGER NOT NULL, state VARCHAR(255) DEFAULT \'enabled\' NOT NULL COLLATE BINARY, management_state VARCHAR(255) DEFAULT \'unmanaged\' NOT NULL COLLATE BINARY, expiry DATE DEFAULT NULL, PRIMARY KEY(member_id, role_id), CONSTRAINT FK_ABE1A6367597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_ABE1A636D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO member_role (member_id, role_id, state, management_state, expiry) SELECT member_id, role_id, state, management_state, expiry FROM __temp__member_role');
        $this->addSql('DROP TABLE __temp__member_role');
        $this->addSql('CREATE INDEX IDX_ABE1A636D60322AC ON member_role (role_id)');
        $this->addSql('CREATE INDEX IDX_ABE1A6367597D3FE ON member_role (member_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_4C62E6387597D3FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, member_id, firstname, nickname, lastname, address, phone_home, phone_mobile, phone_work, email, occupation, relationship, primary_contact, state, management_state, expiry, overrides FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, address CLOB NOT NULL --(DC2Type:json)
        , phone_home VARCHAR(255) DEFAULT NULL, phone_mobile VARCHAR(255) DEFAULT NULL, phone_work VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, occupation VARCHAR(255) DEFAULT NULL, relationship VARCHAR(255) DEFAULT NULL, primary_contact BOOLEAN NOT NULL, state VARCHAR(255) DEFAULT \'enabled\' NOT NULL, management_state VARCHAR(255) DEFAULT \'unmanaged\' NOT NULL, expiry DATE DEFAULT NULL, overrides CLOB DEFAULT \'{}\' NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO contact (id, member_id, firstname, nickname, lastname, address, phone_home, phone_mobile, phone_work, email, occupation, relationship, primary_contact, state, management_state, expiry, overrides) SELECT id, member_id, firstname, nickname, lastname, address, phone_home, phone_mobile, phone_work, email, occupation, relationship, primary_contact, state, management_state, expiry, overrides FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE INDEX IDX_4C62E6387597D3FE ON contact (member_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__member AS SELECT id, membership_number, firstname, lastname, nickname, date_of_birth, gender, address, phone_home, phone_mobile, phone_work, email, state, management_state, expiry, overrides FROM member');
        $this->addSql('DROP TABLE member');
        $this->addSql('CREATE TABLE member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membership_number VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, date_of_birth DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, address CLOB NOT NULL --(DC2Type:json)
        , phone_home VARCHAR(255) DEFAULT NULL, phone_mobile VARCHAR(255) DEFAULT NULL, phone_work VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT \'enabled\' NOT NULL, management_state VARCHAR(255) DEFAULT \'unmanaged\' NOT NULL, expiry DATE DEFAULT NULL, overrides CLOB DEFAULT \'{}\' NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO member (id, membership_number, firstname, lastname, nickname, date_of_birth, gender, address, phone_home, phone_mobile, phone_work, email, state, management_state, expiry, overrides) SELECT id, membership_number, firstname, lastname, nickname, date_of_birth, gender, address, phone_home, phone_mobile, phone_work, email, state, management_state, expiry, overrides FROM __temp__member');
        $this->addSql('DROP TABLE __temp__member');
        $this->addSql('DROP INDEX IDX_ABE1A6367597D3FE');
        $this->addSql('DROP INDEX IDX_ABE1A636D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__member_role AS SELECT member_id, role_id, state, management_state, expiry FROM member_role');
        $this->addSql('DROP TABLE member_role');
        $this->addSql('CREATE TABLE member_role (member_id INTEGER NOT NULL, role_id INTEGER NOT NULL, state VARCHAR(255) DEFAULT \'enabled\' NOT NULL, management_state VARCHAR(255) DEFAULT \'unmanaged\' NOT NULL, expiry DATE DEFAULT NULL, PRIMARY KEY(member_id, role_id))');
        $this->addSql('INSERT INTO member_role (member_id, role_id, state, management_state, expiry) SELECT member_id, role_id, state, management_state, expiry FROM __temp__member_role');
        $this->addSql('DROP TABLE __temp__member_role');
        $this->addSql('CREATE INDEX IDX_ABE1A6367597D3FE ON member_role (member_id)');
        $this->addSql('CREATE INDEX IDX_ABE1A636D60322AC ON member_role (role_id)');
        $this->addSql('DROP INDEX IDX_57698A6AD823E37A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__role AS SELECT id, section_id, name FROM role');
        $this->addSql('DROP TABLE role');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, section_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO role (id, section_id, name) SELECT id, section_id, name FROM __temp__role');
        $this->addSql('DROP TABLE __temp__role');
        $this->addSql('CREATE INDEX IDX_57698A6AD823E37A ON role (section_id)');
        $this->addSql('DROP INDEX IDX_2D737AEFE800F96A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__section AS SELECT id, scout_group_id, name FROM section');
        $this->addSql('DROP TABLE section');
        $this->addSql('CREATE TABLE section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scout_group_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO section (id, scout_group_id, name) SELECT id, scout_group_id, name FROM __temp__section');
        $this->addSql('DROP TABLE __temp__section');
        $this->addSql('CREATE INDEX IDX_2D737AEFE800F96A ON section (scout_group_id)');
    }
}
