<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkMatch extends xPDOSimpleObject
{
    /**
     * @access public.
     * @return String|Null.
     */
    public function getTeamType()
    {
        for ($i = 1; $i <= 2; $i++) {
            if ($this->get('team' . $i . '_club') === $this->xpdo->getOption('sportlink.club')) {
                $team = $this->getOne('Team' . $i);

                if ($team) {
                    return $team->get('type');
                }
            }
        }

        return null;
    }

    /**
     * @access public.
     * @param String $team.
     * @return String.
     */
    public function getLogo($team)
    {
        $path = trim($this->xpdo->getOption('sportlink.logo_path'), '/');
        $base = rtrim($this->xpdo->getOption('base_path', null, MODX_BASE_PATH), '/');

        foreach (['svg', 'png', 'jpg','jpeg', 'gif'] as $extension) {
            $logo = $base . '/' . $path . '/' . strtolower($this->get($team . '_club_id')) . '.' . $extension;

            if (file_exists($logo)) {
                return '/' . $path . '/' . strtolower($this->get($team . '_club_id')) . '.' . $extension;
            }
        }

        return '';
    }
}
