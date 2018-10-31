<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180920124757 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE configuration_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(80) NOT NULL, icon VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE server (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, display_name VARCHAR(180) NOT NULL, url VARCHAR(255) NOT NULL, check_every INTEGER NOT NULL, timeout INTEGER NOT NULL, is_disabled BOOLEAN NOT NULL, notification_email VARCHAR(255) NOT NULL, notification_phone VARCHAR(40) NOT NULL, send_desktop_notification BOOLEAN NOT NULL, use_push_bullet BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, name VARCHAR(150) NOT NULL, parameter VARCHAR(80) NOT NULL, value CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_A5E2A5D7C54C8C93 ON configuration (type_id)');
        $this->addSql('CREATE TABLE response_code (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code INTEGER NOT NULL, description VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE configuration_type');
        $this->addSql('DROP TABLE server');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE response_code');
    }
}
