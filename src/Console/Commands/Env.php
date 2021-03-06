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

use OoFile\DotEnv;
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
     * environment values
     *
     * @var array
     */
    private $env = array(
        "APP_NAME"      => "Silo",
        "APP_ENV"       => "dev",
        "APP_KEY"       => '',
        "APP_VERSION"   => '1.0'
    );

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
        if(!empty($sub))
        {
            switch($sub)
            {
                case 'init' : $this->generateAppKey(); $this->init();
                    $this->output->writeLn("\n Silo environment has been initialized\n\n");
                    exit;
                break;
                case 'dev'  : $this->setDevelopmentMode();  exit; break;
                case 'pro'  : $this->setProductionMode();   exit;  break;
                default     : throw new RunTimeException("Error sub command $sub not recognized\n\n"); break; break;
            }
        }

        $this->output->writeLn("\n Your application is on ");
        env('APP_ENV') == 'dev' ?
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
        $dotEnv = new DotEnv;

        $this->env["APP_DEBUG"]     = 'true';
        $this->env[1]               = 'SEPARATOR';
        $this->env['APP_HOST']      = 'localhost';
        $this->env['APP_SCHEME']    = 'http';
        $this->env['APP_PORT']      = '80';
        $this->env[2]               = 'SEPARATOR';
        $this->env["LOG"]           = 'true';
        $this->env["LOG_CHANNEL"]   = 'true';
        $this->env[3]               = 'SEPARATOR';
        $this->env["DB_DRIVER"]     = 'PDO';
        $this->env["DB_HOST"]       = '127.0.0.1';
        $this->env["DB_PORT"]       = '3306';
        $this->env["DB_NAME"]       = 'silo';
        $this->env["DB_USER"]       = 'root';
        $this->env["DB_PASS"]       = '';

        return $dotEnv->init($this->env);
    }

    /**
     * generate app key method
     *
     * @return void
     */
    private function generateAppKey()
    {
        return $this->env["APP_KEY"]   =  'base64-' . base64_encode(md5(time()));
    }

    /**
     * setting development mode
     *
     * @return void
     */
    private function setDevelopmentMode()
    {
        $this->env["APP_ENV"] = 'dev';
        $this->env["APP_KEY"] = env("APP_KEY"); // don't change app key when switching env
        $this->init();
        return $this->output->writeLn("\n Silo environment has been set to Development \n\n");
    }

    /**
     * setting production mode
     *
     * @return void
     */
    private function setProductionMode()
    {
        $this->env["APP_ENV"] = 'pro';
        $this->env["APP_KEY"] = env("APP_KEY"); // don't change app key when switching env
        $this->init();
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
        $this->output->writeLn("    init  : initialize environment creating .env file.\n");
        $this->output->writeLn("    dev   : set application to development mode.\n");
        $this->output->writeLn("    pro   : set application to production mode.\n\n");
        $this->output->writeLn("  options : \n\n", 'yellow');
        $this->output->writeLn("    no options for this command.\n\n");

        return '';
    }
}