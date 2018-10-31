<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180920125808 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(150) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json_array)
        , created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_A5E2A5D7C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__configuration AS SELECT id, type_id, name, parameter, value FROM configuration');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('CREATE TABLE configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, name VARCHAR(150) NOT NULL COLLATE BINARY, parameter VARCHAR(80) NOT NULL COLLATE BINARY, value CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_A5E2A5D7C54C8C93 FOREIGN KEY (type_id) REFERENCES configuration_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO configuration (id, type_id, name, parameter, value) SELECT id, type_id, name, parameter, value FROM __temp__configuration');
        $this->addSql('DROP TABLE __temp__configuration');
        $this->addSql('CREATE INDEX IDX_A5E2A5D7C54C8C93 ON configuration (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_A5E2A5D7C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__configuration AS SELECT id, type_id, name, parameter, value FROM configuration');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('CREATE TABLE configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, name VARCHAR(150) NOT NULL, parameter VARCHAR(80) NOT NULL, value CLOB NOT NULL)');
        $this->addSql('INSERT INTO configuration (id, type_id, name, parameter, value) SELECT id, type_id, name, parameter, value FROM __temp__configuration');
        $this->addSql('DROP TABLE __temp__configuration');
        $this->addSql('CREATE INDEX IDX_A5E2A5D7C54C8C93 ON configuration (type_id)');
    }
}
