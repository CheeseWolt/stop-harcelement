<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919132703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE alert (id INT AUTO_INCREMENT NOT NULL, alert_sender_id INT NOT NULL, alert_manager_id INT DEFAULT NULL, location_id INT NOT NULL, status_id INT NOT NULL, alert_date DATETIME NOT NULL, event_date DATETIME NOT NULL, ip_address VARCHAR(128) NOT NULL, content LONGTEXT NOT NULL, start_support_date DATETIME DEFAULT NULL, end_support_date DATETIME DEFAULT NULL, INDEX IDX_17FD46C1475AAE49 (alert_sender_id), INDEX IDX_17FD46C1F9315CB3 (alert_manager_id), INDEX IDX_17FD46C164D218E (location_id), INDEX IDX_17FD46C16BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alert_alert_style (alert_id INT NOT NULL, alert_style_id INT NOT NULL, INDEX IDX_5FB5923D93035F72 (alert_id), INDEX IDX_5FB5923DCF39904F (alert_style_id), PRIMARY KEY(alert_id, alert_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alert_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_name (id INT AUTO_INCREMENT NOT NULL, user_manager_id INT NOT NULL, class_level_id INT NOT NULL, name VARCHAR(20) NOT NULL, INDEX IDX_EA5E4949DF59F28F (user_manager_id), INDEX IDX_EA5E4949EB7F80F7 (class_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE private_message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, alert_id INT NOT NULL, date DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_4744FC9BA76ED395 (user_id), INDEX IDX_4744FC9B93035F72 (alert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sex (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, sex_id INT NOT NULL, student_class_name_id INT DEFAULT NULL, user_name VARCHAR(20) NOT NULL, last_name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, phone VARCHAR(10) DEFAULT NULL, address LONGTEXT NOT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649D60322AC (role_id), INDEX IDX_8D93D6495A2DB2A0 (sex_id), INDEX IDX_8D93D649E1FE03B4 (student_class_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1475AAE49 FOREIGN KEY (alert_sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1F9315CB3 FOREIGN KEY (alert_manager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C164D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C16BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE alert_alert_style ADD CONSTRAINT FK_5FB5923D93035F72 FOREIGN KEY (alert_id) REFERENCES alert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alert_alert_style ADD CONSTRAINT FK_5FB5923DCF39904F FOREIGN KEY (alert_style_id) REFERENCES alert_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE class_name ADD CONSTRAINT FK_EA5E4949DF59F28F FOREIGN KEY (user_manager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE class_name ADD CONSTRAINT FK_EA5E4949EB7F80F7 FOREIGN KEY (class_level_id) REFERENCES class_level (id)');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9B93035F72 FOREIGN KEY (alert_id) REFERENCES alert (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495A2DB2A0 FOREIGN KEY (sex_id) REFERENCES sex (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E1FE03B4 FOREIGN KEY (student_class_name_id) REFERENCES class_name (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert_alert_style DROP FOREIGN KEY FK_5FB5923D93035F72');
        $this->addSql('ALTER TABLE private_message DROP FOREIGN KEY FK_4744FC9B93035F72');
        $this->addSql('ALTER TABLE alert_alert_style DROP FOREIGN KEY FK_5FB5923DCF39904F');
        $this->addSql('ALTER TABLE class_name DROP FOREIGN KEY FK_EA5E4949EB7F80F7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E1FE03B4');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C164D218E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495A2DB2A0');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C16BF700BD');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1475AAE49');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1F9315CB3');
        $this->addSql('ALTER TABLE class_name DROP FOREIGN KEY FK_EA5E4949DF59F28F');
        $this->addSql('ALTER TABLE private_message DROP FOREIGN KEY FK_4744FC9BA76ED395');
        $this->addSql('DROP TABLE alert');
        $this->addSql('DROP TABLE alert_alert_style');
        $this->addSql('DROP TABLE alert_style');
        $this->addSql('DROP TABLE class_level');
        $this->addSql('DROP TABLE class_name');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE private_message');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE sex');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
    }
}
