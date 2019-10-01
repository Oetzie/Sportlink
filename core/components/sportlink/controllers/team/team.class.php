<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(__DIR__)) . '/index.class.php';

class SportlinkTeamTeamManagerController extends SportlinkManagerController
{
    /**
     * @access public.
     * @var Object|Null.
     */
    public $team = null;

    /**
     * @access public.
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/team/team.panel.js');

        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/team/competition.grid.js');
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/team/matches.grid.js');
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/team/results.grid.js');

        $this->addLastJavascript($this->modx->sportlink->config['js_url'] . 'mgr/sections/team/team.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                Sportlink.config.record = ' . $this->modx->toJSON($this->getTeam()) . ';
            });
        </script>');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('sportlink');
    }

    /**
    * @access public.
    * @return String.
    */
    public function getTemplateFile()
    {
        return $this->modx->sportlink->config['templates_path'] . 'team/team.tpl';
    }

    /**
     * @access public.
     * @param Array $properties.
     * @return Mixd.
     */
    public function process(array $properties = [])
    {
        $this->setTeam($properties);

        if (!$this->getTeam()) {
            return $this->failure($this->modx->lexicon('sportlink.team_not_exists', [
                'id' => $properties['id']
            ]));
        }
    }

    /**
     * @access public.
     * @param Array $properties.
     */
    public function setTeam(array $properties = [])
    {
        $this->team = $this->modx->getObject('SportlinkTeam', [
            'id' => $properties['id']
        ]);
    }

    /**
     * @access public.
     * @return Null|Array.
     */
    public function getTeam()
    {
        if ($this->team !== null) {
            $team = array_merge($this->team->toArray(), [
                'poule_id' => 0
            ]);

            $competition = $this->modx->getObject('SportlinkCompetition', [
                'team_id'   => $this->team->get('team_id'),
                'type'      => 'regulier'
            ]);

            if ($competition) {
                $team['poule_id'] = $competition->get('poule_id');
            }

            return $team;
        }

        return null;
    }
}
