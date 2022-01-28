<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220128095643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D3DA5256D FOREIGN KEY (image_id) REFERENCES post_image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D3DA5256D ON post (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D3DA5256D');
        $this->addSql('DROP TABLE post_image');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D3DA5256D ON post');
        $this->addSql('ALTER TABLE post DROP image_id');
    }
}
