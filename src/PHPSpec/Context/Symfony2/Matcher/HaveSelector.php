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
 *                                    Luis Cordova
 * @license   http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
namespace PHPSpec\Context\Symfony2\Matcher;

require_once 'PHPUnit/Autoload.php';

/**
 * @see \PHPSpec\Matcher
 */
use \PHPSpec\Matcher,
    \PHPSpec\Util\Validate,
    \PHPSpec\Specification\Interceptor\InterceptorFactory,
    \Zend_Test_PHPUnit_Constraint_DomQuery as DomQuery;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @category   PHPSpec
 * @package    PHPSpec_Zend
 * @copyright  Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright  Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                     Marcello Duarte
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
class HaveSelector implements Matcher
{
    protected $_selector;
    protected $_conditions = array();
    protected $_block;
    
    /**
     * Creates the matcher
     *
     * @param string   $expected
     * @param array    $conditions OPTIONAL
     * @param \Closure $block OPTIONAL
     * @throws \PHPSpec\Exception
     */
    public function __construct($expected)
    {
        switch (func_num_args()) {
            case 1:
                $this->_selector = $expected;
                break;
            case 2:
                $this->_selector = $expected;
                $this->_conditions = Validate::isArray(
                    func_get_arg(1), '2nd', 'Have selector'
                );
                break;
            default:
                throw new \PHPSpec\Exception('Wrong number of arguments');
        }
        
        $this->_expected = $expected;
    }
    
    /**
     * Checks whether value is somewhere in the body
     * 
     * @param Response $response
     * @return boolean
     */
    public function matches($content)
    {
        $this->_actual = $content;
        $constraint = new DomQuery(
            $this->_expected
        );
        if ($constraint->evaluate($content, 'assertQuery')) {
            if (is_array($this->_conditions) && !empty($this->_conditions)) {
                $selector = $this->_expected;
                foreach ($this->_conditions as $name => $value) {
                    if ($name === 'content') {
                        $constraint = new DomQuery($this->_expected);
                        return $constraint->evaluate(
                            $content, 'assertQueryContentContains', $value
                        );
                    }
                    $selector .= "[$name=\"$value\"]";
                }
                $constraint = new DomQuery($selector);
                if ($constraint->evaluate($content, 'assertQuery')) {
                    return true;
                } else {
                    return false;
                }
            }
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
        return 'expected ' . var_export($this->_actual, true) . ' to contain ' .
               var_export($this->_expected, true) .
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