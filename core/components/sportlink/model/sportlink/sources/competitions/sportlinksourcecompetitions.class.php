<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(__DIR__)) . '/sportlinksource.class.php';

class SportlinkSourceCompetitions extends SportlinkSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'Competitions';

    /**
     * @access public.
     * @return Array|String.
     */
    public function getData()
    {
        $output = [
            'competitions'  => [
                'create'        => [],
                'update'        => []
            ],
            'standings'     => [
                'create'        => [],
                'update'        => []
            ],
            'matches'       => [
                'create'        => [],
                'update'        => []
            ],
            'results'       => [
                'create'        => [],
                'update'        => []
            ],
            'cancellations' => [
                'create'        => [],
                'update'        => []
            ]
        ];

        $response = $this->makeRequest('/teams/');

        if ((int) $response['code'] === 200) {
            $competitions = [];

            foreach ((array) $response['data'] as $data) {
                if (empty($data['poulecode']) || in_array($data['poulecode'], $competitions, true)) {
                    continue;
                }

                $competition = $this->modx->getObject('SportlinkCompetition', [
                    'poule_id' => $data['poulecode']
                ]);

                if ($competition) {
                    $output['competitions']['update'][] = $data['poulecode'];
                } else {
                    $competition = $this->modx->newObject('SportlinkCompetition');

                    $output['competitions']['create'][] = $data['poulecode'];
                }

                if ($competition) {
                    $competition->fromArray([
                        'poule_id'  => $data['poulecode'],
                        'team_id'   => $data['teamcode'],
                        'name'      => $data['competitienaam'],
                        'class'     => $data['klasse'],
                        'poule'     => $data['poule'],
                        'type'      => $data['competitiesoort']
                    ]);

                    if ($competition->save()) {
                        $competitions[] = $data['teamcode'];
                    }
                }
            }
        }

        $response = $this->makeRequest('/poulelijst/');

        if ((int) $response['code'] === 200) {
            $standings = [];

            foreach ((array) $response['data'] as $data) {
                if (isset($data['poulecode'])) {
                    $standingResponse = $this->makeRequest('/poulestand/', [
                        'poulecode' => $data['poulecode']
                    ]);

                    if ((int) $standingResponse['code'] === 200) {
                        foreach ((array) $standingResponse['data'] as $stadingData) {
                            $standing = $this->modx->getObject('SportlinkCompetitionStanding', [
                                'poule_id'  => $data['poulecode'],
                                'name'      => $stadingData['teamnaam']
                            ]);

                            if ($standing) {
                                $output['standings']['update'][] = $stadingData['teamnaam'];
                            } else {
                                $standing = $this->modx->newObject('SportlinkCompetitionStanding');

                                $output['standings']['create'][]  = $stadingData['teamnaam'];
                            }

                            if ($standing) {
                                $standing->fromArray([
                                    'poule_id'          => $data['poulecode'],
                                    'club_id'           => $stadingData['clubrelatiecode'],
                                    'rank'              => $stadingData['positie'],
                                    'name'              => $stadingData['teamnaam'],
                                    'matches'           => $stadingData['gespeeldewedstrijden'],
                                    'wins'              => $stadingData['gewonnen'],
                                    'draws'             => $stadingData['gelijk'],
                                    'loses'             => $stadingData['verloren'],
                                    'goals_for'         => $stadingData['doelpuntenvoor'],
                                    'goals_against'     => $stadingData['doelpuntentegen'],
                                    'goal_balance'      => $stadingData['doelsaldo'],
                                    'points_deducted'   => $stadingData['verliespunten'],
                                    'points'            => $stadingData['punten']
                                ]);

                                if ($standing->save()) {
                                    $standings[] = $stadingData['teamnaam'];
                                }
                            }
                        }
                    }

                    $matchResponse = $this->makeRequest('/poule-programma/', [
                        'poulecode'     => $data['poulecode'],
                        'aantaldagen'   => 21
                    ]);

                    if ((int) $matchResponse['code'] === 200) {
                        $matches = [];

                        foreach ((array) $matchResponse['data'] as $matchData) {
                            $match = $this->modx->getObject('SportlinkMatch', [
                                'match_id' => $matchData['wedstrijdcode']
                            ]);

                            if ($match) {
                                $output['matches']['update'][] = $matchData['wedstrijdcode'];
                            } else {
                                $match = $this->modx->newObject('SportlinkMatch');

                                $output['matches']['create'][] = $matchData['wedstrijdcode'];
                            }

                            if ($match) {
                                $match->fromArray([
                                    'poule_id'      => $data['poulecode'],
                                    'match_id'      => $matchData['wedstrijdcode'],
                                    'match_nr'      => $matchData['wedstrijdnummer'],
                                    'match_date'    => strtotime($matchData['wedstrijddatum']),
                                    'team1_id'      => $matchData['thuisteamid'],
                                    'team1_club_id' => $matchData['thuisteamclubrelatiecode'],
                                    'team1_name'    => $matchData['thuisteam'],
                                    'team2_id'      => $matchData['uitteamid'],
                                    'team2_club_id' => $matchData['uitteamclubrelatiecode'],
                                    'team2_name'    => $matchData['uitteam'],
                                    'accommodation' => $matchData['accommodatie'],
                                    'city'          => ucwords(strtolower($matchData['plaats'])),
                                    'status'        => 1
                                ]);

                                if ($match->save()) {
                                    $matches[] = $matchData['wedstrijdcode'];
                                }
                            }
                        }
                    }

                    $resultResponse = $this->makeRequest('/pouleuitslagen/', [
                        'poulecode'     => $data['poulecode'],
                        'aantaldagen'   => 21
                    ]);

                    if ((int) $resultResponse['code'] === 200) {
                        $results = [];

                        foreach ((array) $resultResponse['data'] as $resultData) {
                            $result = $this->modx->getObject('SportlinkMatch', [
                                'match_id' => $resultData['wedstrijdcode']
                            ]);

                            if ($result) {
                                $output['results']['update'][] = $resultData['wedstrijdcode'];
                            } else {
                                $result = $this->modx->newObject('SportlinkMatch');

                                $output['results']['create'][] = $resultData['wedstrijdcode'];
                            }

                            if ($result) {
                                $result->fromArray([
                                    'poule_id'      => $data['poulecode'],
                                    'match_id'      => $resultData['wedstrijdcode'],
                                    'match_nr'      => $resultData['wedstrijdnummer'],
                                    'match_date'    => strtotime($resultData['wedstrijddatum']),
                                    'team1_id'      => $resultData['thuisteamid'],
                                    'team1_club_id' => $resultData['thuisteamclubrelatiecode'],
                                    'team1_name'    => $resultData['thuisteam'],
                                    'team2_id'      => $resultData['uitteamid'],
                                    'team2_club_id' => $resultData['uitteamclubrelatiecode'],
                                    'team2_name'    => $resultData['uitteam'],
                                    'accommodation' => $resultData['accommodatie'],
                                    'status'        => 0
                                ]);

                                if ($resultData['status'] === 'Uitgespeeld') {
                                    $outcome = explode('-', $resultData['uitslag']);

                                    $result->fromArray([
                                        'team1_goals'   => trim($outcome[0]),
                                        'team2_goals'   => trim($outcome[1]),
                                        'status'        => 0
                                    ]);
                                } else {
                                    $result->fromArray([
                                        'team1_goals'   => 0,
                                        'team2_goals'   => 0,
                                        'status'        => 2
                                    ]);
                                }

                                if ($result->save()) {
                                    $results[] = $resultData['wedstrijdcode'];
                                }
                            }
                        }
                    }

                    $cancellationsResponse = $this->makeRequest('/afgelastingen/', [
                        'poulecode'     => $data['poulecode'],
                        'aantaldagen'   => 21
                    ]);

                    if ((int) $cancellationsResponse['code'] === 200) {
                        $cancellations = [];

                        foreach ((array) $cancellationsResponse['data'] as $cancellationData) {
                            $cancellation = $this->modx->getObject('SportlinkMatch', [
                                'match_id' => $cancellationData['wedstrijdcode']
                            ]);

                            if ($cancellation) {
                                $output['cancellations']['update'][] = $cancellationData['wedstrijdcode'];

                                $cancellation->fromArray([
                                    'status' => 2
                                ]);

                                if ($cancellation->save()) {
                                    $cancellations[] = $cancellationData['wedstrijdcode'];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $output;
    }
}
