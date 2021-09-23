<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922100449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_keyword (article_id INT NOT NULL, keyword_id INT NOT NULL, INDEX IDX_B741358C7294869C (article_id), INDEX IDX_B741358C115D4552 (keyword_id), PRIMARY KEY(article_id, keyword_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_keyword ADD CONSTRAINT FK_B741358C7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_keyword ADD CONSTRAINT FK_B741358C115D4552 FOREIGN KEY (keyword_id) REFERENCES keyword (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE keyword_article');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keyword_article (keyword_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_D9BC828115D4552 (keyword_id), INDEX IDX_D9BC8287294869C (article_id), PRIMARY KEY(keyword_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE keyword_article ADD CONSTRAINT FK_D9BC828115D4552 FOREIGN KEY (keyword_id) REFERENCES keyword (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE keyword_article ADD CONSTRAINT FK_D9BC8287294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE article_keyword');
    }
}
