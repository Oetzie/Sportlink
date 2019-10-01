<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

abstract class SportlinkManagerController extends modExtraManagerController
{
    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('sportlink', 'Sportlink', $this->modx->getOption('sportlink.core_path', null, $this->modx->getOption('core_path') . 'components/sportlink/') . 'model/sportlink/');

        $this->addCss($this->modx->sportlink->config['css_url'] . 'mgr/sportlink.css');

        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/sportlink.js');
        $this->addJavascript($this->modx->sportlink->config['js_url'] . 'mgr/extras/extras.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.config.help_url = "' . $this->modx->sportlink->getHelpUrl() . '";

                Sportlink.config = ' . $this->modx->toJSON(array_merge($this->modx->sportlink->config, [
                    'branding_url'          => $this->modx->sportlink->getBrandingUrl(),
                    'branding_url_help'     => $this->modx->sportlink->getHelpUrl()
                ])) . ';
            });
        </script>');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getLanguageTopics()
    {
        return $this->modx->sportlink->config['lexicons'];
    }

    /**
     * @access public.
     * @returns Boolean.
     */
    public function checkPermissions()
    {
        return $this->modx->hasPermission('sportlink');
    }
}

class IndexManagerController extends SportlinkManagerController
{
    /**
     * @access public.
     * @return String.
     */
    public static function getDefaultController()
    {
        return 'home';
    }
}
