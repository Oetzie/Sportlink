<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(__DIR__) . '/sportlinksnippets.class.php';

class SportlinkSnippetMatches extends SportlinkSnippets
{
    /**
     * @access public.
     * @var Array.
     */
    public $properties = [
        'limit'                 => 0,
        'offset'                => 0,
        'type'                  => 'match',
        'team'                  => '',
        'competition'           => '',
        'tpl'                   => '@FILE elements/chunks/matches/item.chunk.tpl',
        'tplWrapper'            => '@FILE elements/chunks/matches/wrapper.chunk.tpl',
        'tplEmpty'              => '@FILE elements/chunks/matches/empty.chunk.tpl',
        'usePdoTools'           => false,
        'usePdoElementsPath'    => false
    ];

    /**
     * @access public.
     * @param Array $properties.
     * @return String.
     */
    public function run(array $properties = [])
    {
        $this->setProperties($properties);

        $output = [];

        $type   = $this->getProperty('type');
        $offset = $this->getDateOffset($this->getProperty('offset'));

        $criteria = $this->modx->newQuery('SportlinkMatch');

        if (!empty($this->getProperty('team'))) {
            $criteria->where([
                'team1_id:='    => $this->getProperty('team'),
                'OR:team2_id:=' => $this->getProperty('team')
             ]);
        }

        if (!empty($this->getProperty('competition'))) {
            $criteria->where([
                'poule_id'      => $this->getProperty('competition'),
            ]);
        }

        if ($type === 'result') {
            if ($offset >= 1) {
                $criteria->where([
                    'match_date:<='     => strtotime('last Sunday'),
                    'AND:match_date:>=' => strtotime('-' . $offset . ' days', strtotime('last Sunday'))
                ]);
            } else {
                $criteria->where([
                    'match_date:<='     => strtotime('last Sunday')
                ]);
            }
        } else {
            if ($offset >= 1) {
                $criteria->where([
                    'match_date:>='     => strtotime('last Sunday'),
                    'AND:match_date:<=' => strtotime('+' . $offset . ' days', strtotime('last Sunday'))
                ]);
            } else {
                $criteria->where([
                    'match_date:>='     => strtotime('last Sunday')
                ]);
            }
        }

        $limit = (int) $this->getProperty('limit');

        if ($limit >= 1) {
            $criteria->limit($limit);
        }

        if ($type === 'result') {
            $criteria->sortby('match_date', 'DESC');
        } else {
            $criteria->sortby('match_date', 'ASC');
        }

        foreach ($this->modx->getCollection('SportlinkMatch', $criteria) as $match) {
            $output[] = $this->getChunk($this->properties['tpl'], array_merge([
                'type'          => $type,
                'team1_logo'    => $match->getLogo('team1'),
                'team2_logo'    => $match->getLogo('team2')
            ], $match->toArray()));
        }

        if (!empty($output)) {
            if (!empty($this->getProperty('tplWrapper'))) {
                return $this->getChunk($this->getProperty('tplWrapper'), [
                    'type'      => $type,
                    'output'    => implode(PHP_EOL, $output)
                ]);
            }

            return implode(PHP_EOL, $output);
        }

        if (!empty($this->getProperty('tplEmpty'))) {
            return $this->getChunk($this->getProperty('tplEmpty'));
        }

        return '';
    }

    /**
     * @access protected.
     * @param String|Integer $offset.
     * @return Integer.
     */
    protected function getDateOffset($offset)
    {
        if (!is_numeric($offset)) {
            if ($offset === '1 week') {
                $offset = 7;
            } else if ($offset === '2 week') {
                $offset = 14;
            } else if ($offset === '3 week') {
                $offset = 21;
            } else {
                $offset = 28;
            }
        }

        return (int) $offset;
    }
}
