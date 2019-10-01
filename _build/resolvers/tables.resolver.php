<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->addPackage('sportlink', $modx->getOption('sportlink.core_path', null, $modx->getOption('core_path') . 'components/sportlink/') . 'model/');

            $manager = $modx->getManager();

            $manager->createObjectContainer('SportlinkTeam');
            $manager->createObjectContainer('SportlinkCompetition');
            $manager->createObjectContainer('SportlinkCompetitionStanding');
            $manager->createObjectContainer('SportlinkMatch');

            break;
    }
}

return true;
