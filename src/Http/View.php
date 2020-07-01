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
    /**
     * render view method using caprice templating engine
     *
     * @param  string $file
     * @param  mixed  $data
     * @return void
     */
    public function render(string $file, $data = NULL)
    {
        $caprice  = new Compiler(Conf::path("views"), Conf::path("cache") . "views");

        if(_env("APP_ENV") != "dev")
            $caprice->setProductionMode();

        $compiled = $caprice->compile($file);
        $data     = $data;
        require $compiled;
    }
}