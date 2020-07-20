<?php

namespace Omniscient\Console\Commands;

/**
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.2.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 *
 * @time      Generated at 12-09-2019 by conso
 */

use OoFile\Conf;
use Conso\Conso;
use Conso\Command as BaseCommand;
use Conso\Exceptions\InputException;
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Assets extends BaseCommand implements CommandInterface
{
   /**
     * sub commands
     *
     * @var array
     */
    protected $sub = array(
        'publish'
    );

    /**
     * flags
     *
     * @var array
     */
    protected $flags = array(
    );

    /**
     * command help
     *
     * @var string
     */
    protected $help  = array(
        "sub commands" => array(
            "publish"  => 'publish assets to public folder'
        )
    );

    /**
     * command description method
     *
     * @return string
     */
    protected $description = "Asset command to publish, delete, update assets.";

    /**
     * execute method
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Conso $app
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output, Conso $app) : void
    {
        $this->displayCommandHelp($input, $output, $app);
    }

    /**
     * publish assets
     *
     * @return void
     */
    public function publish(InputInterface $input, OutputInterface $output)
    {
        $assets = Conf::path('assets');
        $pub    = Conf::path('pub');

        if(!is_writable($pub))
            throw new \Exception("$pub Directory is not writable \n\n");

        chdir($pub); // switch to public folder

        if(is_link("assets"))
            (PHP_OS == 'WINNT') ? system("rmdir assets") : unlink("assets");

        if(symlink($assets, "assets"))
            return $output->writeLn("\n assets has been published to the public folder.\n\n", "green");

        throw new \Exception("\error publishing assets to public folder.\n\n", "red");
    }
}