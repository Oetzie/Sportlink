<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(__DIR__) . '/index.class.php';

class SportlinkHomeManagerController extends SportlinkManagerController
{
    /**
     * @access public.
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/home.panel.js');

        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/teams.grid.js');
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/matches.grid.js');
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/widgets/results.grid.js');

        $this->addLastJavascript($this->modx->sportlink->config['js_url'] . 'mgr/sections/home.js');
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
        return $this->modx->sportlink->config['templates_path'] . 'home.tpl';
    }
}
