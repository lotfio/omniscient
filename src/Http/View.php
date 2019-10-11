<?php namespace Omniscient\Http;

/**
 * @author    <contact@lotfio.net>
 * @package   Silo PHP framework
 * @version   1.0.0
 * @license   MIT
 * @category  Framework
 * @copyright 2019 Lotfio Lakehal
 */
use Caprice\Compiler;
use OoFile\Conf;

class View
{
    public function render(string $file, $data = NULL)
    {
        $caprice  = new Compiler;
        $compiled = $caprice->compile(Conf::path("views") . $file , Conf::path("cache") . "views");
        $data     = $data;
        require $compiled;
    }
}