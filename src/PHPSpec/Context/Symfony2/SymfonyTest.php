<?php

namespace PHPSpec\Context\Symfony2;

use \Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @category   PHPSpec
 * @package    PHPSpec_Symfony2
 * @copyright  Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright  Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                     Marcello Duarte
 *                                     Luis Cordova
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
class SymfonyTest extends WebTestCase
{
    public $bootstrap;
    
    /**
     * Creates a Symfony test client object into the bootstrap property
     */
    public function __construct()
    {
        $this->bootstrap = $this->createClient();
    }
}