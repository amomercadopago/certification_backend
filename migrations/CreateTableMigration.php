<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Laminas\Di\Exception\MissingPropertyException;

trait CreateTableMigration
{
    /**
     * @throws SchemaException
     * @throws MissingPropertyException
     */
    public function up(Schema $schema): void
    {
        $this->validateClass();

        $table = $schema->createTable($this->tableName);

        foreach ($this->tableColumns as $column) {
            $table->addColumn($column['name'], $column['type'], $column['options'] ?? []);

            if (isset($column['custom'])) {
                if (isset($column['custom']['index'])) {
                    $table->addIndex([$column['name']]);
                }
                if (isset($column['custom']['primary'])) {
                    $table->setPrimaryKey([$column['name']], $column['custom']['primary']['index'] ?? false);
                }
                if (isset($column['custom']['foreign'])) {
                    $table->addForeignKeyConstraint(
                        $schema->getTable($column['custom']['foreign']['table_name']),
                        [$column['name']],
                        [$column['custom']['foreign']['column_name']]
                    );
                }
            }
        }

        if (isset($this->complex)) {
            foreach ($this->complex as $complex) {
                if (isset($complex['primary'])) {
                    $table->setPrimaryKey($complex['columns']);
                }
            }
        }
    }

    /**
     * @param Schema $schema
     * @return void
     * @throws SchemaException
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable($this->tableName);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "Creating $this->tableName table";
    }

    /**
     * @return void
     * @throws MissingPropertyException
     */
    private function validateClass(): void
    {
        if (!property_exists($this, 'tableName')) {
            throw new MissingPropertyException('Can not find $tableName class property');
        }
        if (!property_exists($this, 'tableColumns')) {
            throw new MissingPropertyException('Can not find $tableColumns class property');
        }
    }
}
