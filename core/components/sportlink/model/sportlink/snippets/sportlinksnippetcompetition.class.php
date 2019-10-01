<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(__DIR__) . '/sportlinksnippets.class.php';

class SportlinkSnippetCompetition extends SportlinkSnippets
{
    /**
     * @access public.
     * @var Array.
     */
    public $properties = [
        'team'                  => '',
        'competition'           => '',
        'type'                  => 'regulier',
        'tpl'                   => '@FILE elements/chunks/competition/item.chunk.tpl',
        'tplWrapper'            => '@FILE elements/chunks/competition/wrapper.chunk.tpl',
        'tplEmpty'              => '@FILE elements/chunks/competition/empty.chunk.tpl',
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

        $competition = $this->getCompetition();

        if ($competition) {
            $output = [];

            $criteria = $this->modx->newQuery('SportlinkCompetitionStanding');

            $criteria->where([
                'poule_id' => $competition->get('poule_id')
            ]);

            $criteria->sortby('rank', 'ASC');

            foreach ($this->modx->getCollection('SportlinkCompetitionStanding', $criteria) as $standing) {
                $output[] = $this->getChunk($this->getProperty('tpl'), array_merge([
                    'logo'  => $standing->getLogo()
                ], $standing->toArray()));
            }

            if (!empty($output)) {
                if (!empty($this->getProperty('tplWrapper'))) {
                    return $this->getChunk($this->getProperty('tplWrapper'), [
                        'competition'   => $competition->toArray(),
                        'output'        => implode(PHP_EOL, $output)
                    ]);
                }

                return implode(PHP_EOL, $output);
            }
        }

        if (!empty($this->getProperty('tplEmpty'))) {
            return $this->getChunk($this->getProperty('tplEmpty'));
        }

        return '';
    }

    /**
     * @access protected.
     * @return Null|Object.
     */
    protected function getCompetition()
    {
        if (!empty($this->getProperty('team'))) {
            return $this->modx->getObject('SportlinkCompetition', [
                'team_id'   => $this->getProperty('team'),
                'type'      => strtolower($this->getProperty('type'))
            ]);
        }

        if (!empty($this->getProperty('competition'))) {
            return $this->modx->getObject('SportlinkCompetition', [
                'poule_id'  => $this->getProperty('competition')
            ]);
        }

        return null;
    }
}
