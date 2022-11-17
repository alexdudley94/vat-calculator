<?php

declare (strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116210255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calculation_result (id INT AUTO_INCREMENT NOT NULL, original_value DOUBLE PRECISION NOT NULL, vat_percentage DOUBLE PRECISION NOT NULL, value_inc_vat DOUBLE PRECISION NOT NULL, value_excl_vat DOUBLE PRECISION NOT NULL, amount_of_vat_added DOUBLE PRECISION NOT NULL, amount_of_vat_excluded DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calculation_result');
    }
}
