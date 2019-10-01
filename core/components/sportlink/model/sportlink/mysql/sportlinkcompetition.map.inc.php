<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SportlinkCompetition'] = [
    'package'           => 'sportlink',
    'version'           => '1.0',
    'table'             => 'sportlink_competition',
    'extends'           => 'xPDOSimpleObject',
    'fields'            => [
        'id'                => null,
        'poule_id'          => null,
        'team_id'           => null,
        'name'              => null,
        'class'             => null,
        'poule'             => null,
        'type'              => null,
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
        'poule_id'          => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
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
        'class'             => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'poule'             => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'type'          => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false
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
        'Team'              => [
            'local'             => 'poule_id',
            'class'             => 'SportlinkTeam',
            'foreign'           => 'poule_id',
            'owner'             => 'foreign',
            'cardinality'       => 'one'
        ],
        'Result'            => [
            'local'             => 'poule_id',
            'class'             => 'SportlinkCompetitionResult',
            'foreign'           => 'poule_id',
            'owner'             => 'local',
            'cardinality'       => 'many'
        ],
        'Match'             => [
            'local'             => 'poule_id',
            'class'             => 'SportlinkMatches',
            'foreign'           => 'poule_id',
            'owner'             => 'local',
            'cardinality'       => 'many'
        ]
    ]
];
