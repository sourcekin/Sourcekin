<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

namespace Sourcekin\Components;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class SchemaFactory
{
    public static function makeInstallationSchema()
    {
        $schema = new Schema();

        self::makeStreamsTable($schema);
        self::makeProjectionsTable($schema);
        self::makeSnapshotsTable($schema);

        return $schema;

    }

    /**
     * @param Schema $schema
     */
    protected static function makeStreamsTable($schema): void
    {
        $streams = $schema->createTable('event_streams');
        $streams->addColumn(
            'no',
            Type::BIGINT,
            [
                'notnull'       => true,
                'autoincrement' => true,
                'unsigned'      => true
            ]
        );
        $streams->addColumn(
            'real_stream_name',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 150,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $streams->addColumn(
            'stream_name',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 41,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $streams->addColumn(
            'metadata',
            Type::TEXT,
            [
                'notnull'             => true,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $streams->addColumn(
            'category',
            Type::STRING,
            [
                'notnull'             => false,
                'length'              => 150,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $streams->addUniqueIndex(['real_stream_name'], 'idx_rsn');
        $streams->addIndex(['category'], 'idx_category');
        $streams->setPrimaryKey(['no']);
        $streams->addOption('charset', 'utf8');
        $streams->addOption('collate', 'utf8_bin');
    }

    /**
     * @param Schema $schema
     */
    protected static function makeProjectionsTable($schema): void
    {
        $projections = $schema->createTable('projections');
        $projections->addColumn(
            'no',
            Type::BIGINT,
            [
                'notnull'       => true,
                'autoincrement' => true,
                'unsigned'      => true
            ]
        );
        $projections->addColumn(
            'name',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 150,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $projections->addColumn(
            'position',
            Type::TEXT,
            [
                'notnull'             => true,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $projections->addColumn(
            'state',
            Type::TEXT,
            [
                'notnull'             => true,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $projections->addColumn(
            'status',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 28,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $projections->addColumn(
            'locked_until',
            Type::STRING,
            [
                'notnull'             => false,
                'fixed'               => true,
                'length'              => 26,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $projections->addUniqueIndex(['name'], 'idx_name');
        $projections->setPrimaryKey(['no']);
        $projections->addOption('charset', 'utf8');
        $projections->addOption('collate', 'utf8_bin');
    }

    /**
     * @param Schema $schema
     */
    protected static function makeSnapshotsTable($schema): void
    {
        $snapshots = $schema->createTable('snapshots');
        $snapshots->addColumn(
            'aggregate_id',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 150,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $snapshots->addColumn(
            'aggregate_type',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 150,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $snapshots->addColumn(
            'last_version',
            Type::BIGINT,
            [
                'notnull'  => true,
                'unsigned' => true
            ]
        );
        $snapshots->addColumn(
            'created_at',
            Type::STRING,
            [
                'notnull'             => true,
                'length'              => 26,
                'fixed'               => true,
                'customSchemaOptions' => ['collate' => 'utf8_bin']
            ]
        );
        $snapshots->addColumn(
            'aggregate_root',
            Type::BLOB,
            [
                'notnull' => false
            ]
        );

        $snapshots->setPrimaryKey(['aggregate_id']);
        $snapshots->addIndex(['aggregate_type'], 'idx_type');
        $snapshots->addIndex(['aggregate_id'], 'idx_ag_id');
        $snapshots->addIndex(['last_version'], 'idx_lv');
        $snapshots->addOption('charset', 'utf8');
        $snapshots->addOption('collate', 'utf8_bin');
    }
}