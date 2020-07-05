<?php

/**
 * @author    <contact@lotfio.net>
 * @package   Silo PHP framework
 * @version   1.0.0
 * @license   MIT
 * @category  Framework
 * @copyright 2019 Lotfio Lakehal
 */

use Omniscient\Http\View;
use OoFile\{Conf, Env};


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

if(!function_exists('view'))
{
    /**
     * view helper function
     *
     * @param  string $file
     * @return void
     */
    function view(string $file, $data = NULL)
    {
        return (new View)->render($file, $data);
    }
}

if(!function_exists('_env'))
{
    /**
     * env helper method
     *
     * @param  string  $key
     * @param  string  $default
     * @return ?string
     */
    function _env(string $key, string $default = NULL) : ?string
    {
        //$env        = new Env(explode('vendor', __DIR__)[0]);
        $env        = new Env('C:\Users\dell\Desktop\own\silo\lotfio-silo');
                    $env->load();
        return      $env->get($key, $default);
    }
}