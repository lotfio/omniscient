<?php

/**
 * @author    <contact@lotfio.net>
 * @package   Silo PHP framework
 * @version   1.0.0
 * @license   MIT
 * @category  Framework
 * @copyright 2019 Lotfio Lakehal
 */

use OoFile\Conf;


if(!function_exists('url'))
{
    /**
     * url helper function
     *
     * @param string $additional
     * @return void
     */
    function url(string $additional = NULL)
    {
        return Conf::link('url') . ltrim($additional, '/');
    }
}