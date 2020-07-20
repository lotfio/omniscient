<?php

namespace Omniscient\Console\Commands;

/**
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 *
 * @time      Generated at 28-08-2019 by conso
 */

use OoFile\Conf;
use Conso\Conso;
use Conso\Command as BaseCommand;
use Conso\Exceptions\InputException;
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Start extends BaseCommand implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub = array(
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
    );

    /**
     * command description method
     *
     * @return string
     */
    protected $description = "Start command to start the build in php server.";

    /**
     * server ip address
     *
     * @var string
     */
    protected $host = "127.0.0.1";

    /**
     * server port
     *
     * @var string
     */
    protected $port = "8080";

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
        /**
         * check for available port
         */
        $this->checkAvailablePort();

        $host    = _env('APP_HOST',$this->host);
        $port    = _env('APP_PORT',$this->port);
        $command = "php -S " . $host . ":" . $port . " -t " . Conf::path('pub');

        $output->writeLn("\n Starting development server : \n", "yellow");
        $output->writeLn(" You can now visit <http://$host:$port> \n", "yellow");

        passthru($command);
    }

    /**
     * check if port is available
     *
     * @param string $range
     * @return void
     */
    public function checkAvailablePort()
    {
        try{ // skip fsock warning since we are using exception handler
            //  it will throw a warning exception and catch it
            $con      = fsockopen($this->host, $this->port);
            if($con)
            {
                ++$this->port;
                $con = fsockopen($this->host, $this->port);
            }
            fclose($con);
            return $this->port;

        }catch(\Exception $e){}
    }
}