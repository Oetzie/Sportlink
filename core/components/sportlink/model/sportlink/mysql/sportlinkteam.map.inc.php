<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SportlinkTeam'] = [
    'package'           => 'sportlink',
    'version'           => '1.0',
    'table'             => 'sportlink_team',
    'extends'           => 'xPDOSimpleObject',
    'fields'            => [
        'id'                => null,
        'team_id'           => null,
        'name'              => null,
        'type'              => null,
        'sex'               => null,
        'category'          => null,
        'editedon'          => null
    ],
    'fieldMeta'         => [
        'id'                => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false,
            'index'             => 'pk',
            'generated'         => 'native'
        ],
        'team_id'           => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'name'              => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'type'              => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'sex'               => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'category'          => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'editedon'      => [
            'dbtype'        => 'timestamp',
            'phptype'       => 'timestamp',
            'attributes'    => 'ON UPDATE CURRENT_TIMESTAMP',
            'null'          => false,
            'default'       => '0000-00-00 00:00:00'
        ]
    ],
    'indexes'           => [
        'PRIMARY'           => [
            'alias'             => 'PRIMARY',
            'primary'           => true,
            'unique'            => true,
            'columns'           => [
                'id'                => [
                    'collation'         => 'A',
                    'null'              => false
                ]
            ]
        ]
    ],
    'aggregates'        => [
        'Competition'       => [
            'local'             => 'team_id',
            'class'             => 'SportlinkCompetition',
            'foreign'           => 'team_id',
            'owner'             => 'local',
            'cardinality'       => 'many'
        ]
    ]
];
