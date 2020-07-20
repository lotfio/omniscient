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
use Conso\Conso;
use Conso\Command as BaseCommand;
use Conso\Exceptions\InputException;
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Env extends BaseCommand implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub = array(
        'init','keygen','dev','pro'
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
            "init"   => "initialize environment and create .env file",
            "keygen" => "generate a new application key",
            "dev"    => "set development mode",
            "pro"    => "set production mode"
        )
    );

    /**
     * command description
     *
     * @var string
     */
    protected $description = 'Env command to show and update application environment.';

    /**
     * environment object
     *
     * @var array
     */
    private $envPath = 'C:\Users\dell\Desktop\own\silo\lotfio-silo';

    /**
     * command execute method
     *
     * @param  string $sub
     * @param  array  $options
     * @param  array  $flags
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output, Conso $app) : void
    {
        $output->writeLn("\n Your application is on ");

        _env('APP_ENV') == 'dev'
                        ? $output->writeLn("development mode\n", 'green')
                        : $output->writeLn("production mode\n", 'green');
    }

    /**
     * env init method
     *
     * @return void
     */
    public function init(InputInterface $input, OutputInterface $output)
    {
        $env = new  OoEnv($this->envPath);
        $env->loadExample();

        $env->set('APP_DEBUG', 'true')
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

        $output->writeLn("\n Silo environment has been initialized\n", "green");
    }

    /**
     * generate app key method
     *
     * @return void
     */
    public function keygen(InputInterface $input, OutputInterface $output)
    {
        $env = new  OoEnv($this->envPath);
        $env->load();
        $env->set('APP_KEY', 'base64-' . base64_encode(md5(time())))->update();
        return $output->writeLn("\n Env key has been generated successfully \n\n", 'green');
    }

    /**
     * setting development mode
     *
     * @return void
     */
    public function dev(InputInterface $input, OutputInterface $output)
    {
        $env = new  OoEnv($this->envPath);
        $env->load();
        $env->set('APP_ENV', 'dev')->set('APP_KEY', _env("APP_KEY"))->update();

        return $output->writeLn("\n Silo environment has been set to Development mode \n", 'green');
    }

    /**
     * setting production mode
     *
     * @return void
     */
    public function pro(InputInterface $input, OutputInterface $output)
    {
        $env = new  OoEnv($this->envPath);
        $env->load();
        $env->set('APP_ENV', 'pro')->set('APP_KEY', _env("APP_KEY"))->update();

        return $output->writeLn("\n Silo environment has been set to Production \n", 'red');
    }
}