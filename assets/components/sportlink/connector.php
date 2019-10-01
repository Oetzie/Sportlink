<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';

require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->getService('sportlink', 'Sportlink', $modx->getOption('sportlink.core_path', null, $modx->getOption('core_path') . 'components/sportlink/') . 'model/sportlink/');

if ($modx->sportlink instanceOf Sportlink) {
    $modx->request->handleRequest([
        'processors_path'   => $modx->sportlink->config['processors_path'],
        'location'          => ''
    ]);
}

?>