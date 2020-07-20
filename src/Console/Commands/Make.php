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
 * @time      Generated at 30-08-2019 by conso
 */

use Conso\Conso;
use OOFile\{Conf, File};
use Conso\Command as BaseCommand;
use Conso\Exceptions\InputException;
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Make extends BaseCommand implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub = array(
        'controller','model','view'
    );

    /**
     * flags
     *
     * @var array
     */
    protected $flags = array(
        '-c', '--crud'
    );

    /**
     * command help
     *
     * @var string
     */
    protected $help  = array(
    );

    /**
     * command description
     *
     * @var string
     */
    protected $description = 'make command to create controllers, models, views and more.';

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
     * create controller method
     *
     * @return void
     */
    public function controller(InputInterface $input, OutputInterface $output)
    {
        $options = $input->options();
        $flags   = $input->flags();

        if(!isset($options[0]))
            throw new \Exception("controller name is required");

        $name       = ucfirst($options[0]);
        $controller = Conf::path('controllers') . $name . '.php';

        $file = new File;
        if($file->exists($controller)) // already exists
            throw new \Exception("controller $controller already exists.");

        // stub file
        $stub = (isset($flags[0]) && in_array($flags[0], $this->flags)) ? 'crud': 'controller';
        $stubController = $file->read(dirname(__DIR__) . '/stub/' . $stub);
        $stubController = str_replace('#name#', $name, $stubController);

        if($file->create($controller))
           if($file->write($controller, $stubController))
                die($output->writeLn("\n $name created successfully \n", 'yellow'));

        $output->writeLn("error creating $name controller .\n\n", "red");
    }
}