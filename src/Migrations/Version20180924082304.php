<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180924082304 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__server AS SELECT id, display_name, url, check_every, timeout, is_disabled, notification_email, notification_phone, send_desktop_notification, use_push_bullet, last_status_verification FROM server');
        $this->addSql('DROP TABLE server');
        $this->addSql('CREATE TABLE server (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, display_name VARCHAR(180) NOT NULL COLLATE BINARY, url VARCHAR(255) NOT NULL COLLATE BINARY, check_every INTEGER NOT NULL, timeout INTEGER NOT NULL, is_disabled BOOLEAN NOT NULL, notification_email VARCHAR(255) NOT NULL COLLATE BINARY, notification_phone VARCHAR(40) NOT NULL COLLATE BINARY, send_desktop_notification BOOLEAN NOT NULL, use_push_bullet BOOLEAN NOT NULL, last_status_verification DATETIME DEFAULT NULL, CONSTRAINT FK_5A6DD5F67E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO server (id, display_name, url, check_every, timeout, is_disabled, notification_email, notification_phone, send_desktop_notification, use_push_bullet, last_status_verification) SELECT id, display_name, url, check_every, timeout, is_disabled, notification_email, notification_phone, send_desktop_notification, use_push_bullet, last_status_verification FROM __temp__server');
        $this->addSql('DROP TABLE __temp__server');
        $this->addSql('CREATE INDEX IDX_5A6DD5F67E3C61F9 ON server (owner_id)');
        $this->addSql('DROP INDEX IDX_613A7A9A76ED395');
        $this->addSql('DROP INDEX IDX_613A7A91844E6B7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__server_user AS SELECT server_id, user_id FROM server_user');
        $this->addSql('DROP TABLE server_user');
        $this->addSql('CREATE TABLE server_user (server_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(server_id, user_id), CONSTRAINT FK_613A7A91844E6B7 FOREIGN KEY (server_id) REFERENCES server (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_613A7A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO server_user (server_id, user_id) SELECT server_id, user_id FROM __temp__server_user');
        $this->addSql('DROP TABLE __temp__server_user');
        $this->addSql('CREATE INDEX IDX_613A7A9A76ED395 ON server_user (user_id)');
        $this->addSql('CREATE INDEX IDX_613A7A91844E6B7 ON server_user (server_id)');
        $this->addSql('DROP INDEX IDX_74D654201844E6B7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__monitor_history AS SELECT id, server_id, server_status, response_code, load_time, created_at FROM monitor_history');
        $this->addSql('DROP TABLE monitor_history');
        $this->addSql('CREATE TABLE monitor_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, server_id INTEGER NOT NULL, server_status VARCHAR(40) NOT NULL COLLATE BINARY, response_code INTEGER NOT NULL, load_time DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_74D654201844E6B7 FOREIGN KEY (server_id) REFERENCES server (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO monitor_history (id, server_id, server_status, response_code, load_time, created_at) SELECT id, server_id, server_status, response_code, load_time, created_at FROM __temp__monitor_history');
        $this->addSql('DROP TABLE __temp__monitor_history');
        $this->addSql('CREATE INDEX IDX_74D654201844E6B7 ON monitor_history (server_id)');
        $this->addSql('DROP INDEX IDX_8D93D649727ACA70');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, parent_id, name, email, username, password, roles, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, username VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json_array)
        , created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_8D93D649727ACA70 FOREIGN KEY (parent_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, parent_id, name, email, username, password, roles, created_at, updated_at) SELECT id, parent_id, name, email, username, password, roles, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649727ACA70 ON user (parent_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_A5E2A5D7C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__configuration AS SELECT id, type_id, name, parameter, value FROM configuration');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('CREATE TABLE configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, name VARCHAR(150) NOT NULL COLLATE BINARY, parameter VARCHAR(80) NOT NULL COLLATE BINARY, value CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_A5E2A5D7C54C8C93 FOREIGN KEY (type_id) REFERENCES configuration_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO configuration (id, type_id, name, parameter, value) SELECT id, type_id, name, parameter, value FROM __temp__configuration');
        $this->addSql('DROP TABLE __temp__configuration');
        $this->addSql('CREATE INDEX IDX_A5E2A5D7C54C8C93 ON configuration (type_id)');
        $this->addSql('DROP INDEX IDX_DBB43A02A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__response_code AS SELECT id, user_id, code, description FROM response_code');
        $this->addSql('DROP TABLE response_code');
        $this->addSql('CREATE TABLE response_code (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, code INTEGER NOT NULL, description VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_DBB43A02A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO response_code (id, user_id, code, description) SELECT id, user_id, code, description FROM __temp__response_code');
        $this->addSql('DROP TABLE __temp__response_code');
        $this->addSql('CREATE INDEX IDX_DBB43A02A76ED395 ON response_code (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_A5E2A5D7C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__configuration AS SELECT id, type_id, name, parameter, value FROM configuration');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('CREATE TABLE configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, name VARCHAR(150) NOT NULL, parameter VARCHAR(80) NOT NULL, value CLOB NOT NULL)');
        $this->addSql('INSERT INTO configuration (id, type_id, name, parameter, value) SELECT id, type_id, name, parameter, value FROM __temp__configuration');
        $this->addSql('DROP TABLE __temp__configuration');
        $this->addSql('CREATE INDEX IDX_A5E2A5D7C54C8C93 ON configuration (type_id)');
        $this->addSql('DROP INDEX IDX_74D654201844E6B7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__monitor_history AS SELECT id, server_id, server_status, response_code, load_time, created_at FROM monitor_history');
        $this->addSql('DROP TABLE monitor_history');
        $this->addSql('CREATE TABLE monitor_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, server_id INTEGER NOT NULL, server_status VARCHAR(40) NOT NULL, response_code INTEGER NOT NULL, load_time DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO monitor_history (id, server_id, server_status, response_code, load_time, created_at) SELECT id, server_id, server_status, response_code, load_time, created_at FROM __temp__monitor_history');
        $this->addSql('DROP TABLE __temp__monitor_history');
        $this->addSql('CREATE INDEX IDX_74D654201844E6B7 ON monitor_history (server_id)');
        $this->addSql('DROP INDEX IDX_DBB43A02A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__response_code AS SELECT id, user_id, code, description FROM response_code');
        $this->addSql('DROP TABLE response_code');
        $this->addSql('CREATE TABLE response_code (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, code INTEGER NOT NULL, description VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO response_code (id, user_id, code, description) SELECT id, user_id, code, description FROM __temp__response_code');
        $this->addSql('DROP TABLE __temp__response_code');
        $this->addSql('CREATE INDEX IDX_DBB43A02A76ED395 ON response_code (user_id)');
        $this->addSql('DROP INDEX IDX_5A6DD5F67E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__server AS SELECT id, display_name, url, check_every, timeout, is_disabled, notification_email, notification_phone, send_desktop_notification, use_push_bullet, last_status_verification FROM server');
        $this->addSql('DROP TABLE server');
        $this->addSql('CREATE TABLE server (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, display_name VARCHAR(180) NOT NULL, url VARCHAR(255) NOT NULL, check_every INTEGER NOT NULL, timeout INTEGER NOT NULL, is_disabled BOOLEAN NOT NULL, notification_email VARCHAR(255) NOT NULL, notification_phone VARCHAR(40) NOT NULL, send_desktop_notification BOOLEAN NOT NULL, use_push_bullet BOOLEAN NOT NULL, last_status_verification DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO server (id, display_name, url, check_every, timeout, is_disabled, notification_email, notification_phone, send_desktop_notification, use_push_bullet, last_status_verification) SELECT id, display_name, url, check_every, timeout, is_disabled, notification_email, notification_phone, send_desktop_notification, use_push_bullet, last_status_verification FROM __temp__server');
        $this->addSql('DROP TABLE __temp__server');
        $this->addSql('DROP INDEX IDX_613A7A91844E6B7');
        $this->addSql('DROP INDEX IDX_613A7A9A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__server_user AS SELECT server_id, user_id FROM server_user');
        $this->addSql('DROP TABLE server_user');
        $this->addSql('CREATE TABLE server_user (server_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(server_id, user_id))');
        $this->addSql('INSERT INTO server_user (server_id, user_id) SELECT server_id, user_id FROM __temp__server_user');
        $this->addSql('DROP TABLE __temp__server_user');
        $this->addSql('CREATE INDEX IDX_613A7A91844E6B7 ON server_user (server_id)');
        $this->addSql('CREATE INDEX IDX_613A7A9A76ED395 ON server_user (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX IDX_8D93D649727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, parent_id, name, email, username, password, roles, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json_array)
        , created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO user (id, parent_id, name, email, username, password, roles, created_at, updated_at) SELECT id, parent_id, name, email, username, password, roles, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE INDEX IDX_8D93D649727ACA70 ON user (parent_id)');
    }
}
