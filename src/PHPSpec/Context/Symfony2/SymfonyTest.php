<?php

namespace PHPSpec\Context\Symfony2;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

require_once __DIR__ . '/../../../../../../app/bootstrap.php.cache';
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
die(var_dump(get_include_path()));
class SymfonyTest extends WebTestCase
{
    public $client;
    
    /**
     * Creates a Symfony test client object into the bootstrap property
     */
    public function __construct()
    {
        $this->client = $this->createClient();

    }
}