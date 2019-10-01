<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$xpdo_meta_map['SportlinkCompetitionStanding'] = [
    'package'           => 'sportlink',
    'version'           => '1.0',
    'table'             => 'sportlink_competition_standing',
    'extends'           => 'xPDOSimpleObject',
    'fields'            => [
        'id'                => null,
        'poule_id'          => null,
        'club_id'           => null,
        'rank'              => null,
        'name'              => null,
        'matches'           => null,
        'wins'              => null,
        'draws'             => null,
        'loses'             => null,
        'goals_for'         => null,
        'goals_against'     => null,
        'goal_balance'      => null,
        'points_deducted'   => null,
        'points'            => null,
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
        'club_id'           => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'rank'              => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false
        ],
        'name'              => [
            'dbtype'            => 'varchar',
            'precision'         => '75',
            'phptype'           => 'string',
            'null'              => false
        ],
        'matches'           => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'wins'              => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'draws'             => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'loses'             => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'goals_for'         => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'goals_against'     => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'goal_balance'      => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'points_deducted'   => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
        ],
        'points'            => [
            'dbtype'            => 'int',
            'precision'         => '3',
            'phptype'           => 'integer',
            'null'              => false,
            'default'           => 0
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
            'local'             => 'poule_id',
            'class'             => 'SportlinkCompetition',
            'foreign'           => 'poule_id',
            'owner'             => 'foreign',
            'cardinality'       => 'one'
        ]
    ]
];

?>