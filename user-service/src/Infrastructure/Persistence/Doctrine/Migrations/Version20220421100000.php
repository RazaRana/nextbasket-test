<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;


use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220421100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user table';
    }

    public function up(Schema $schema): void
    {
        $userTable = $schema->createTable('user');
        $userTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true, 'notnull' => true]);
        $userTable->addColumn('email', 'string', ['length' => 255, 'notnull' => true]);
        $userTable->addColumn('first_name', 'string', ['length' => 255, 'notnull' => true]);
        $userTable->addColumn('last_name', 'string', ['length' => 255, 'notnull' => true]);
        $userTable->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user');
    }
}
