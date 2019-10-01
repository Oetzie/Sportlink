<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkCompetitionsGetListProcessor extends modObjectGetListProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SportlinkCompetition';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['sportlink:default'];
		
    /**
     * @access public.
     * @var String.
     */
    public $defaultSortField = 'name';

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortDirection = 'ASC';

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'sportlink.competition';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('sportlink', 'Sportlink', $this->modx->getOption('sportlink.core_path', null, $this->modx->getOption('core_path') . 'components/sportlink/') . 'model/sportlink/');

        $this->setDefaultProperties([
            'dateFormat' => $this->modx->getOption('manager_date_format') . ', ' . $this->modx->getOption('manager_time_format')
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
        $team = $this->getProperty('team_id');

        if (!empty($team)) {
            $criteria->where([
                'team_id' => $team
            ]);
        }

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where([
                'name:LIKE'     => '%' . $query . '%',
                'OR:class:LIKE' => '%' . $query . '%'
            ]);
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
        return array_merge($object->toArray(), [
            'type'              => $this->modx->lexicon('sportlink.competition_type_' . $object->get('type')),
            'class_formatted'   => $object->get('class') . ' - ' . $object->get('poule')
        ]);
    }
}

return 'SportlinkCompetitionsGetListProcessor';
