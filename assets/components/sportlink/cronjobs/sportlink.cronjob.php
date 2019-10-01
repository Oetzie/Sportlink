<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('web');

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

/*
 * Put the options in the $options variable.
 * We use getopt for CLI executions and $_GET for http executions.
 */
$options = [];

if (XPDO_CLI_MODE) {
    $options = getopt('', ['debug', 'hash::', 'sources::']);
} else {
    $options = $_GET;
}

if (!isset($options['hash']) || $options['hash'] !== $modx->getOption('sportlink.cronjob_hash')) {
    $modx->log(modX::LOG_LEVEL_INFO, 'ERROR:: Cannot initialize service, no valid hash provided.');

    exit();
}

$service = $modx->getService('sportlinkcronjob', 'SportlinkCronjob', $modx->getOption('sportlink.core_path', null, $modx->getOption('core_path') . 'components/sportlink/') . 'model/sportlink/');

if ($service instanceof Sportlink) {
    if (isset($options['sources'])) {
        $service->setSources($options['sources']);
    }

    if (isset($options['debug'])) {
        $service->setDebugMode(true);
    }

    $service->run();
} else {
    $modx->log(modX::LOG_LEVEL_INFO, 'ERROR:: Cannot initialize service.');
}
