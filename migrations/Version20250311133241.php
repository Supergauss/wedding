<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311133241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Zusage verlängert';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE invitation set date_must_promise="2025-03-31 23:59:59"');
    }

    public function down(Schema $schema): void
    {

    }
}
