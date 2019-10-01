<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkCompetitionStanding extends xPDOSimpleObject
{
    /**
     * @access public,
     * @return String.
     */
    public function getLogo()
    {
        $path = trim($this->xpdo->getOption('sportlink.logo_path'), '/');
        $base = rtrim($this->xpdo->getOption('base_path', null, MODX_BASE_PATH), '/');

        foreach (['svg', 'png', 'jpg','jpeg', 'gif'] as $extension) {
            $logo = $base . '/' . $path . '/' . strtolower($this->get('club_id')) . '.' . $extension;

            if (file_exists($logo)) {
                return '/' . $path . '/' . strtolower($this->get('club_id')) . '.' . $extension;
            }
        }

        return '';
    }
}
