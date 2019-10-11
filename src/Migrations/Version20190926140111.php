<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190926140111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FE252916B');
        $this->addSql('DROP TABLE rating');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F71868B2E');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F9D86650F');
        $this->addSql('DROP INDEX IDX_6970EB0F9D86650F ON reviews');
        $this->addSql('DROP INDEX IDX_6970EB0FE252916B ON reviews');
        $this->addSql('DROP INDEX IDX_6970EB0F71868B2E ON reviews');
        $this->addSql('ALTER TABLE reviews DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reviews ADD book_id INT NOT NULL, ADD user_id INT NOT NULL, ADD rating DOUBLE PRECISION NOT NULL, DROP book_id_id, DROP user_id_id, DROP rating_id_id');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F16A2B381 ON reviews (book_id)');
        $this->addSql('CREATE INDEX IDX_6970EB0FA76ED395 ON reviews (user_id)');
        $this->addSql('ALTER TABLE reviews ADD PRIMARY KEY (book_id, user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F16A2B381');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('DROP INDEX IDX_6970EB0F16A2B381 ON reviews');
        $this->addSql('DROP INDEX IDX_6970EB0FA76ED395 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reviews ADD book_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, ADD rating_id_id INT NOT NULL, DROP book_id, DROP user_id, DROP rating');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F71868B2E FOREIGN KEY (book_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FE252916B FOREIGN KEY (rating_id_id) REFERENCES rating (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F9D86650F ON reviews (user_id_id)');
        $this->addSql('CREATE INDEX IDX_6970EB0FE252916B ON reviews (rating_id_id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F71868B2E ON reviews (book_id_id)');
        $this->addSql('ALTER TABLE reviews ADD PRIMARY KEY (book_id_id, user_id_id)');
    }
}
