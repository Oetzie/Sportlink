<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SportlinkMatch'] = [
    'package'           => 'sportlink',
    'version'           => '1.0',
    'table'             => 'sportlink_match',
    'extends'           => 'xPDOSimpleObject',
    'fields'            => [
        'id'                => null,
        'poule_id'          => null,
        'match_id'          => null,
        'match_nr'          => null,
        'match_date'        => null,
        'team1_id'          => null,
        'team1_club_id'     => null,
        'team1_name'        => null,
        'team1_goals'       => null,
        'team2_id'          => null,
        'team2_club_id'     => null,
        'team2_name'        => null,
        'team2_goals'       => null,
        'accommodation'     => null,
        'city'              => null,
        'status'            => null
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
        'match_id'          => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'match_nr'          => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'match_date'        => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'team1_id'          => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'team1_club_id'     => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'team1_name'        => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'team1_goals'       => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'team2_id'          => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'team2_club_id'     => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'team2_name'        => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'team2_goals'       => [
            'dbtype'            => 'int',
            'precision'         => '11',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'accommodation'     => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'city'              => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'status'            => [
            'dbtype'            => 'int',
            'precision'         => '1',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 1
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
            'local'             => 'poule_id',
            'class'             => 'SportlinkCompetition',
            'foreign'           => 'poule_id',
            'owner'             => 'foreign',
            'cardinality'       => 'one'
        ],
        'Team1'             => [
            'local'             => 'team1_id',
            'class'             => 'SportlinkTeam',
            'foreign'           => 'team_id',
            'owner'             => 'foreign',
            'cardinality'       => 'one'
        ],
        'Team2'             => [
            'local'             => 'team2_id',
            'class'             => 'SportlinkTeam',
            'foreign'           => 'team_id',
            'owner'             => 'foreign',
            'cardinality'       => 'one'
        ]
    ]
];
