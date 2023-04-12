<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412134256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, relation_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_description (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, description_id INT DEFAULT NULL, picture_category_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, etat VARCHAR(255) DEFAULT NULL, INDEX IDX_8F7C2FC0D9F966B (description_id), INDEX IDX_8F7C2FC08C0ED801 (picture_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A3256915B FOREIGN KEY (relation_id) REFERENCES pictures (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC0D9F966B FOREIGN KEY (description_id) REFERENCES picture_description (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC08C0ED801 FOREIGN KEY (picture_category_id) REFERENCES picture_category (id)');
        $this->addSql('ALTER TABLE picture_category_pictures DROP FOREIGN KEY FK_91E8F0868C0ED801');
        $this->addSql('DROP TABLE picture_category_pictures');
        $this->addSql('ALTER TABLE picture_category ADD category VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_category_pictures (picture_category_id INT NOT NULL, pictures_id INT NOT NULL, INDEX IDX_91E8F0868C0ED801 (picture_category_id), INDEX IDX_91E8F086BC415685 (pictures_id), PRIMARY KEY(picture_category_id, pictures_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture_category_pictures ADD CONSTRAINT FK_91E8F0868C0ED801 FOREIGN KEY (picture_category_id) REFERENCES picture_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A3256915B');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC0D9F966B');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC08C0ED801');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE picture_description');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE picture_category DROP category');
    }
}
