<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(__DIR__)) . '/sportlinksource.class.php';

class SportlinkSourceTeams extends SportlinkSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'Teams';

    /**
     * @access public.
     * @return Array.
     */
    public function getData()
    {
        $output = [
            'teams' => [
                'create' => [],
                'update' => []
            ]
        ];

        $response = $this->makeRequest('/teams/');

        if ((int) $response['code'] === 200) {
            $teams = [];

            foreach ((array) $response['data'] as $data) {
                if (empty($data['kalespelsoort']) || in_array($data['teamcode'], $teams, true)) {
                    continue;
                }

                $team = $this->modx->getObject('SportlinkTeam', [
                    'team_id' => $data['teamcode']
                ]);

                if ($team) {
                    $output['teams']['update'][] = $data['teamcode'];
                } else {
                    $team = $this->modx->newObject('SportlinkTeam');

                    $output['teams']['create'][] = $data['teamcode'];
                }

                if ($team) {
                    $team->fromArray([
                        'team_id'   => $data['teamcode'],
                        'name'      => $data['teamnaam'],
                        'type'      => strtolower($data['kalespelsoort']),
                        'sex'       => $data['geslacht'],
                        'category'  => $data['leeftijdscategorie']
                    ]);

                    if ($team->save()) {
                        $teams[] = $data['teamcode'];
                    }
                }
            }
        }

        return $output;
    }
}
