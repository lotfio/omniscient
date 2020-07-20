<?php

/**
 * @author    <contact@lotfio.net>
 * @package   Silo PHP framework
 * @version   1.0.0
 * @license   MIT
 * @category  Framework
 * @copyright 2019 Lotfio Lakehal
 *
 */

$silo->command('env'  , "Omniscient\\Console\\Commands\\Env");
$silo->command('serve', "Omniscient\\Console\\Commands\\Serve");
$silo->command('make' , "Omniscient\\Console\\Commands\\Make");
$silo->command('asset', "Omniscient\\Console\\Commands\\Asset");
