<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822190242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41C9B257F8F253B ON cliente (dni)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05D7F8F253B ON usuario (dni)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F41C9B257F8F253B ON cliente');
        $this->addSql('DROP INDEX UNIQ_2265B05D7F8F253B ON usuario');
    }
}
