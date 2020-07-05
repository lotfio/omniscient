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

use OoFile\Env as OoEnv;
use Conso\Command;
use Conso\Contracts\CommandInterface;
use Conso\Exceptions\{OptionNotFoundException, FlagNotFoundException, RunTimeException};

class Env extends Command implements CommandInterface
{
    /**
     * command flags
     *
     * @var array
     */
    protected $flags = [];

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
    protected $description = "Env command to show and update application environment.";

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
        // set up env object
        $this->env = new  OoEnv('C:\Users\dell\Desktop\own\silo\lotfio-silo');

        if(!empty($sub))
        {
            switch($sub)
            {
                case 'init'         : $this->init();                exit; break;
                case 'keygen'       : $this->generateAppKey();      exit; break;
                case 'dev'          : $this->setDevelopmentMode();  exit; break;
                case 'pro'          : $this->setProductionMode();   exit;  break;
                default             : throw new RunTimeException("Error sub command $sub not recognized\n\n"); break; break;
            }
        }

        $this->output->writeLn("\n Your application is on ");
        _env('APP_ENV') == 'dev' ?
            $this->output->writeLn("development mode\n\n", 'green')
        :   $this->output->writeLn("production mode\n\n", 'green');
    }

    /**
     * env init method
     *
     * @return void
     */
    private function init()
    {
        $this->env->loadExample();

        $this->env->set('APP_DEBUG', 'true')
                    ->set('APP_HOST', '127.0.0.1')
                    ->set('APP_KEY', 'base64-' . base64_encode(md5(time())))
                    ->set('APP_VERSION', '1.0.0')
                    ->set('APP_SCHEME', 'http')
                    ->set('APP_PORT', '8080')

                    ->set('LOG', '')
                    ->set('LOG_CHANNEL', '')

                    ->set('DB_DRIVER', 'PDO')
                    ->set('DB_HOST', '127.0.0.1')
                    ->set('DB_PORT', '3306')
                    ->set('DB_NAME', 'silo')
                    ->set('DB_USER', 'root')
                    ->set('DB_PASS', '')
                    ->update();

        $this->output->writeLn("\n Silo environment has been initialized\n\n", "green");
    }

    /**
     * generate app key method
     *
     * @return void
     */
    private function generateAppKey()
    {
        $this->env->load();
        $this->env->set('APP_KEY', 'base64-' . base64_encode(md5(time())))->update();
        return $this->output->writeLn("\n Env key has been generated successfully \n\n", 'green');
    }

    /**
     * setting development mode
     *
     * @return void
     */
    private function setDevelopmentMode()
    {
        $this->env->load();
        $this->env->set('APP_ENV', 'dev')->set('APP_KEY', _env("APP_KEY"))->update();

        return $this->output->writeLn("\n Silo environment has been set to Development \n\n");
    }

    /**
     * setting production mode
     *
     * @return void
     */
    private function setProductionMode()
    {
        $this->env->load();
        $this->env->set('APP_ENV', 'pro')->set('APP_KEY', _env("APP_KEY"))->update();

        return $this->output->writeLn("\n Silo environment has been set to Production \n\n");
    }

     /**
     * command help method.
     *
     * @return string
     */
    public function help()
    {
        $this->output->writeLn("\n [ env ] \n\n", 'yellow');
        $this->output->writeLn("   env command to show and update application environment.\n\n");
        $this->output->writeLn("  sub commands : \n\n", 'yellow');
        $this->output->writeLn("    init     : initialize environment creating .env file.\n");
        $this->output->writeLn("    keygen  : generate new environment key.\n");
        $this->output->writeLn("    dev     : set application to development mode.\n");
        $this->output->writeLn("    pro     : set application to production mode.\n\n");
        $this->output->writeLn("  options   : \n\n", 'yellow');
        $this->output->writeLn("    no options for this command.\n\n");

        return '';
    }
}