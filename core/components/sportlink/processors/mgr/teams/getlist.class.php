<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkTeamsGetListProcessor extends modObjectGetListProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SportlinkTeam';

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
    public $objectType = 'sportlink.team';

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
        $type = $this->getProperty('type');

        if (!empty($type)) {
            $criteria->where([
                'type' => $type
            ]);
        }

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $criteria->where([
                'team_id:LIKE'  => '%' . $query . '%',
                'OR:name:LIKE'  => '%' . $query . '%'
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
        $array = array_merge($object->toArray(), [
            'type'  => $this->modx->lexicon('sportlink.team_type_' . $object->get('type')),
            'sex'   => $this->modx->lexicon('sportlink.sex_' . $object->get('sex'))
        ]);

        if (in_array($object->get('editedon'), ['-001-11-30 00:00:00', '-1-11-30 00:00:00', '0000-00-00 00:00:00', null], true)) {
            $array['editedon'] = '';
        } else {
            $array['editedon']   = date($this->getProperty('dateFormat'), strtotime($object->get('editedon')));
        }

        return $array;
    }
}

return 'SportlinkTeamsGetListProcessor';
