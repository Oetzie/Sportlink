<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$class = $modx->loadClass('SportlinkSnippetMatches', $modx->getOption('sportlink.core_path', null, $modx->getOption('core_path') . 'components/sportlink/') . 'model/sportlink/snippets/', false, true);

if ($class) {
    $instance = new $class($modx);

    if ($instance instanceof SportlinkSnippets) {
        return $instance->run($scriptProperties);
    }
}

return '';
