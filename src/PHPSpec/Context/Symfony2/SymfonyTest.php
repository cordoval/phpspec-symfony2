<?php

namespace PHPSpec\Context\Symfony2;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

//require_once __DIR__ . '/../../../../../../app/bootstrap.php.cache';
//require_once __DIR__ . '/../../../../../../app/AppKernel.php';

/**
 * @category   PHPSpec
 * @package    PHPSpec_Symfony2
 * @copyright  Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright  Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                     Marcello Duarte
 *                                     Luis Cordova
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
//die(var_dump(get_include_path()));
class SymfonyTest extends WebTestCase
{
    public $client;
    public $kernel1;
    public $container1;
    
    /**
     * Creates a Symfony test client object into the bootstrap property
     */
    public function init()
    {
        //$kernelDir = __DIR__ . '/../../../../../../app';
        //$this->client = static::createClient(array('test', true), array('KERNEL_DIR' => $kernelDir));
        $this->client = static::createClient(array('test', true));
        $this->kernel1 = $this->client->getKernel();
        $this->container1 = $this->client->getContainer();
    }

    /**
     * Finds the directory where the phpunit.xml(.dist) is stored.
     *
     * If you run tests with the PHPUnit CLI tool, everything will work as expected.
     * If not, override this method in your test classes.
     *
     * @return string The directory where phpunit.xml(.dist) is stored
     */
    static protected function getPhpUnitXmlDir()
    {
        if (!isset($_SERVER['argv']) || false === strpos($_SERVER['argv'][0], 'phpunit')) {
            //throw new \RuntimeException('You must override the WebTestCase::createKernel() method.');
        }

        $kernelDir = __DIR__ . '/../../../../../../app';
        
        $dir = $kernelDir; //static::getPhpUnitCliConfigArgument();
        if ($dir === null &&
            (is_file(getcwd().DIRECTORY_SEPARATOR.'phpunit.xml') ||
            is_file(getcwd().DIRECTORY_SEPARATOR.'phpunit.xml.dist'))) {
            $dir = getcwd();
        }

        // Can't continue
        if ($dir === null) {
            throw new \RuntimeException('Unable to guess the Kernel directory.');
        }

        if (!is_dir($dir)) {
            $dir = dirname($dir);
        }

        return $dir;
    }

}