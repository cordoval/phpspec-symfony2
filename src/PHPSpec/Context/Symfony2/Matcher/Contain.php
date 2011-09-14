<?php

/**
 * PHPSpec
 *
 * LICENSE
 *
 * This file is subject to the GNU Lesser General Public License Version 3
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/lgpl-3.0.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@phpspec.net so we can send you a copy immediately.
 *
 * @category  PHPSpec
 * @package   PHPSpec
 * @copyright Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                    Marcello Duarte
 * @license   http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
namespace PHPSpec\Context\Symfony2\Matcher;

require_once 'PHPUnit/Autoload.php';

/**
 * @see \PHPSpec\Matcher
 */
use \PHPSpec\Matcher;

/**
 * @category   PHPSpec
 * @package    PHPSpec_Zend
 * @copyright  Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright  Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                     Marcello Duarte
 *                                     Luis Cordova
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
class Contain implements Matcher
{
    /**
     * 
     * @param string $expected
     */
    public function __construct($expected)
    {
        $this->_expected = $expected;
    }
    
    /**
     * Checks whether value is somewhere in the body
     * 
     * @param Response $response
     * @return boolean
     */
    public function matches($actual)
    {
        $actual = preg_replace('/(<style>.*?<\/style>)/', '', $actual);
        $actual = preg_replace('/(<script>.*?<\/script>)/', '', $actual);
        $actual = preg_replace('/(<head>.*?<\/head>)/', '', $actual);
        $actual = strip_tags($actual);
        if (strpos($actual, $this->_expected) !== false) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns failure message in case we are using should
     * 
     * @return string
     */
    public function getFailureMessage()
    {
        return 'expected to contain ' . var_export($this->_expected, true) .
               ', found no match (using contain())';
    }

    /**
     * Returns failure message in case we are using should not
     * 
     * @return string
     */
    public function getNegativeFailureMessage()
    {
        return 'expected not to contain' . var_export($this->_expected, true) .
               ', but found a match (using contain())';
    }

    /**
     * Returns the matcher description
     * 
     * @return string
     */
    public function getDescription()
    {
        return 'contain';
    }
}