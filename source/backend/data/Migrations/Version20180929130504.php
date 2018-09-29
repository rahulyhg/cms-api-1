<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180929130504 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users CHANGE resetToken resetToken VARCHAR(256) DEFAULT NULL, CHANGE emailConfirmToken emailConfirmToken VARCHAR(256) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users CHANGE resetToken resetToken VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci, CHANGE emailConfirmToken emailConfirmToken VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci');
    }
}
