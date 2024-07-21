<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720101834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_prestation (article_id INT NOT NULL, prestation_id INT NOT NULL, INDEX IDX_6D115E2C7294869C (article_id), INDEX IDX_6D115E2C9E45C554 (prestation_id), PRIMARY KEY(article_id, prestation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_prestation ADD CONSTRAINT FK_6D115E2C7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_prestation ADD CONSTRAINT FK_6D115E2C9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_prestation DROP FOREIGN KEY FK_6D115E2C7294869C');
        $this->addSql('ALTER TABLE article_prestation DROP FOREIGN KEY FK_6D115E2C9E45C554');
        $this->addSql('DROP TABLE article_prestation');
    }
}
