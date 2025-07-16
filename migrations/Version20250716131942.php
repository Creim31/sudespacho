<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250716131942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE productos CHANGE tipo_iva tipo_iva INT NOT NULL, CHANGE fecha_creacion fecha_creacion DATETIME NOT NULL, CHANGE fecha_actualizacion fecha_actualizacion DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE productos CHANGE tipo_iva tipo_iva VARCHAR(2) NOT NULL, CHANGE fecha_creacion fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE fecha_actualizacion fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
