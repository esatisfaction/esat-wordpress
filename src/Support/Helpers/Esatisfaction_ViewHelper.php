<?php

/*
 * This file is part of the e-satisfaction WordPress plugin.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__ . '/Esatisfaction_StringHelper.php';

/**
 * Class Esatisfaction_ViewHelper
 */
class Esatisfaction_ViewHelper
{
    /**
     * @param string $path
     * @param array  $parameters
     */
    public static function echoView($path, $parameters = [])
    {
        echo self::getView($path, $parameters);
    }

    /**
     * @param string $path
     * @param array  $parameters
     *
     * @return string
     */
    public static function getView($path, $parameters = [])
    {
        // Load file
        $view = file_get_contents(__DIR__ . sprintf('/../../../assets/views/%s.html', $path));

        // Interpolate variables
        return Esatisfaction_StringHelper::interpolate($view, $parameters);
    }
}
