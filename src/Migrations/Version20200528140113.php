<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528140113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, auth_token VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_57698A6AD823E37A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__role AS SELECT id, section_id, name FROM role');
        $this->addSql('DROP TABLE role');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, section_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_57698A6AD823E37A FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO role (id, section_id, name) SELECT id, section_id, name FROM __temp__role');
        $this->addSql('DROP TABLE __temp__role');
        $this->addSql('CREATE INDEX IDX_57698A6AD823E37A ON role (section_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_57698A6AD823E37A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__role AS SELECT id, section_id, name FROM role');
        $this->addSql('DROP TABLE role');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, section_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO role (id, section_id, name) SELECT id, section_id, name FROM __temp__role');
        $this->addSql('DROP TABLE __temp__role');
        $this->addSql('CREATE INDEX IDX_57698A6AD823E37A ON role (section_id)');
    }
}
