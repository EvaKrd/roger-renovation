<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207095103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture_categorie_pictures DROP FOREIGN KEY FK_EF3ACCE085681CAA');
        $this->addSql('ALTER TABLE picture_categorie_pictures DROP FOREIGN KEY FK_EF3ACCE0BC415685');
        $this->addSql('DROP TABLE picture_categorie');
        $this->addSql('DROP TABLE picture_categorie_pictures');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_categorie (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE picture_categorie_pictures (picture_categorie_id INT NOT NULL, pictures_id INT NOT NULL, INDEX IDX_EF3ACCE0BC415685 (pictures_id), INDEX IDX_EF3ACCE085681CAA (picture_categorie_id), PRIMARY KEY(picture_categorie_id, pictures_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture_categorie_pictures ADD CONSTRAINT FK_EF3ACCE085681CAA FOREIGN KEY (picture_categorie_id) REFERENCES picture_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_categorie_pictures ADD CONSTRAINT FK_EF3ACCE0BC415685 FOREIGN KEY (pictures_id) REFERENCES pictures (id) ON DELETE CASCADE');
    }
}
