<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910133736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE caracteristique ADD title_caracteristique_id INT NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ADD CONSTRAINT FK_D14FBE8B7BA2DE62 FOREIGN KEY (title_caracteristique_id) REFERENCES title_caracteristique (id)');
        $this->addSql('CREATE INDEX IDX_D14FBE8B7BA2DE62 ON caracteristique (title_caracteristique_id)');
        $this->addSql('ALTER TABLE title_caracteristique ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE title_caracteristique ADD CONSTRAINT FK_17812224584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_17812224584665A ON title_caracteristique (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE caracteristique DROP FOREIGN KEY FK_D14FBE8B7BA2DE62');
        $this->addSql('DROP INDEX IDX_D14FBE8B7BA2DE62 ON caracteristique');
        $this->addSql('ALTER TABLE caracteristique DROP title_caracteristique_id');
        $this->addSql('ALTER TABLE title_caracteristique DROP FOREIGN KEY FK_17812224584665A');
        $this->addSql('DROP INDEX IDX_17812224584665A ON title_caracteristique');
        $this->addSql('ALTER TABLE title_caracteristique DROP product_id');
    }
}
