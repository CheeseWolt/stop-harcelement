<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190924132052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert ADD event_time TIME NOT NULL, CHANGE alert_manager_id alert_manager_id INT DEFAULT NULL, CHANGE event_date event_date DATE NOT NULL, CHANGE start_support_date start_support_date DATETIME DEFAULT NULL, CHANGE end_support_date end_support_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE student_class_name_id student_class_name_id INT DEFAULT NULL, CHANGE phone phone VARCHAR(10) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert DROP event_time, CHANGE alert_manager_id alert_manager_id INT DEFAULT NULL, CHANGE event_date event_date DATETIME NOT NULL, CHANGE start_support_date start_support_date DATETIME DEFAULT \'NULL\', CHANGE end_support_date end_support_date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE student_class_name_id student_class_name_id INT DEFAULT NULL, CHANGE phone phone VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
