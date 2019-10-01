<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkCompetitionStandingGetListProcessor extends modObjectGetListProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SportlinkCompetitionStanding';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['sportlink:default'];

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortField = 'rank';

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortDirection = 'ASC';

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'sportlink.competition_standing';

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
        $poule = $this->getProperty('poule_id');

        if (!empty($poule)) {
            $criteria->where([
                'poule_id' => $poule
            ]);
        }

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $criteria->where([
                'name:LIKE' => '%' . $query . '%'
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
            'logo' => $object->getLogo()
        ]);
    }
}

return 'SportlinkCompetitionStandingGetListProcessor';
