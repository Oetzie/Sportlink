<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkCompetitionsMatchesGetMatchesProcessor extends modObjectGetListProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SportlinkMatch';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['sportlink:default'];

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortField = 'Match.match_date';

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortDirection = 'ASC';

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'sportlink.match';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('sportlink', 'Sportlink', $this->modx->getOption('sportlink.core_path', null, $this->modx->getOption('core_path') . 'components/sportlink/') . 'model/sportlink/');

        $this->setDefaultProperties([
            'dateFormat' => $this->modx->getOption('manager_date_format') .', '. $this->modx->getOption('manager_time_format')
        ]);

        return parent::initialize();
    }

    /**
     * @access public.
     * @param xPDOQuery $criteria.
     * @return xPDOQuery.
     */
    public function prepareQueryBeforeCount(xPDOQuery $criteria)
    {
        $criteria->setClassAlias('Match');

        $criteria->select($this->modx->getSelectColumns('SportlinkMatch', 'Match'));
        $criteria->select($this->modx->getSelectColumns('SportlinkCompetition', 'Competition', 'competition_', ['type']));

        $criteria->leftJoin('SportlinkCompetition', 'Competition');

        $week = $this->getProperty('week');
        $type = $this->getProperty('type');

        if (empty($week)) {
            if ($type === 'results') {
                $criteria->where([
                    'Match.match_date:<='   => strtotime('next Sunday', strtotime('-0 weeks')),
                    'Match.status:IN'       => [0, 2]
                ]);
            } else {
                $criteria->where([
                    'Match.match_date:>='   => strtotime('last Monday', strtotime('+0 weeks')),
                    'Match.status:IN'       => [1, 2]
                ]);
            }
        } else {
            if ($type === 'results') {
                $criteria->where([
                    'Match.match_date:<='   => strtotime('next Sunday', strtotime('-' . ($week - 1) . ' weeks')),
                    'Match.match_date:>='   => strtotime('-6 days', strtotime('next Sunday', strtotime('-' . ($week - 1) . ' weeks'))),
                    'Match.status:IN'       => [0, 2]
                ]);
            } else {
                $criteria->where([
                    'Match.match_date:>='   => strtotime('last Monday', strtotime('+' . ($week - 1) . ' weeks')),
                    'Match.match_date:<='   => strtotime('+6 days', strtotime('last Monday', strtotime('+' . ($week - 1) . ' weeks'))),
                    'Match.status:IN'       => [1, 2]
                ]);
            }
        }

        $poule = $this->getProperty('poule_id');

        if (!empty($poule)) {
            $criteria->where([
                'Match.poule_id' => $poule
            ]);
        }

        $competitionType = $this->getProperty('competition_type');

        if (!empty($competitionType)) {
            $criteria->where([
                'Competition.type' => $competitionType
            ]);
        }

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $criteria->where([
                'Match.team1_name:LIKE'     => '%' . $query . '%',
                'OR:Match.team2_name:LIKE'  => '%' . $query . '%'
            ]);
        }

        return $criteria;
    }

    /**
     * @access public.
     * @param xPDOQuery $criteria.
     * @return xPDOQuery.
     */
    public function prepareQueryAfterCount(xPDOQuery $criteria)
    {
        $type = $this->getProperty('type');

        if ($type === 'results') {
            $this->setProperty('dir', 'DESC');
        } else {
            $this->setProperty('dir', 'ASC');
        }

        return $criteria;
    }

    /**
     * @access public.
     * @param xPDOObject $object.
     * @return Array.
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = array_merge($object->toArray(), [
            'match_date'        => date($this->getProperty('dateFormat'), $object->get('match_date')),
            'team_type'         => $this->modx->lexicon('sportlink.unknown'),
            'competition_type'  => $this->modx->lexicon('sportlink.unknown')
        ]);

        $teamType = $object->getTeamType();

        if ($teamType) {
            $array['team_type'] = $this->modx->lexicon('sportlink.team_type_' . $teamType);
        }

        $competitionType = $object->get('competition_type');

        if (!empty($competitionType)) {
            $array['competition_type'] = $this->modx->lexicon('sportlink.competition_type_' . $competitionType);
        }

        return $array;
    }
}

return 'SportlinkCompetitionsMatchesGetMatchesProcessor';
