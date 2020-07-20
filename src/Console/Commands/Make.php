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

use Conso\Command;
use OOFile\{Conf, File};
use Conso\Contracts\CommandInterface;
use Conso\Exceptions\{OptionNotFoundException, FlagNotFoundException, RunTimeException};

class Make extends Command implements CommandInterface
{
    /**
     * command flags
     *
     * @var array
     */
    protected $flags = ['-c', '--crud'];

    /**
     * environment object
     *
     * @var array
     */
    private $env;

    /**
     * command description method
     *
     * @return string
     */
    protected $description = "make command to create controllers, models, views and more.";

    /**
     * command execute method
     *
     * @param  string $sub
     * @param  array  $options
     * @param  array  $flags
     * @return void
     */
    public function execute(string $sub, array $options, array $flags)
    {
        switch($sub)
        {
            case 'controller'   : $this->createController($options, $flags);          exit; break;
            case 'model'        : $this->createModel();               exit; break;
            case 'view'         : $this->createView();                exit; break;
            default             : throw new RunTimeException("Error sub command $sub not recognized"); break;
        }
    }


    /**
     * create controller method
     *
     * @return void
     */
    public function createController(array $options, array $flags)
    {
        if(!isset($options[0]))
            throw new RunTimeException("controller name is required");

        $name       = ucfirst($options[0]);
        $controller = Conf::path('controllers') . $name . '.php';

        $file = new File;
        if($file->exists($controller)) // already exists
            throw new RunTimeException("controller $controller already exists.");

        // stub file
        $stub = (isset($flags[0]) && in_array($flags[0], $this->flags)) ? 'crud': 'controller';
        $stubController = $file->read(dirname(__DIR__) . '/stub/' . $stub);
        $stubController = str_replace('#name#', $name, $stubController);

        if($file->create($controller))
           if($file->write($controller, $stubController))
                die($this->output->writeLn("\n $name created successfully \n", 'yellow'));

        $this->output->writeLn("error creating $name controller .\n\n", "red");
    }


     /**
     * command help method.
     *
     * @return string
     */
    public function help()
    {
        $this->output->writeLn("\n [ make ] \n\n", 'yellow');
        $this->output->writeLn("   make command to create controllers, models, views and more.\n\n");
        $this->output->writeLn("  sub commands: \n\n", 'yellow');
        $this->output->writeLn("    controller : initialize environment creating .env file.\n");
        $this->output->writeLn("    model      : generate new environment key.\n");
        $this->output->writeLn("    view       : set application to development mode.\n\n");

        $this->output->writeLn("  options: \n\n", 'yellow');
        $this->output->writeLn("    name       : controller, model or view name.\n\n");

        $this->output->writeLn("  Flags: \n\n", 'yellow');
        $this->output->writeLn("    -c, --crud : crud controller.\n\n");

        return '';
    }
}