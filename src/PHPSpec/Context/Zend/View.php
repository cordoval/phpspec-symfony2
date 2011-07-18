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
namespace PHPSpec\Context\Zend;

use \PHPSpec\Context,
    \PHPSpec\Util\Filter;

/**
 * @category   PHPSpec
 * @package    PHPSpec_Zend
 * @copyright  Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright  Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                     Marcello Duarte
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
class View extends Context
{
    public $rendered;
    protected $_view;
    protected $_viewScript;
    protected $_controllerName;
    
    /**
     * Creates the view context
     */
    public function __construct()
    {
        $path = array_reverse(explode('\\', get_class($this)));
        $moduleName = '';
        $controllerName = 'index';
        switch (count($path)) {
            case 3:
                $moduleName = Filter::camelCaseToDash($path[2]);
            case 2:
                $controllerName = Filter::camelCaseToDash($path[1]);
            case 1:
                $viewName = Filter::camelCaseToDash(substr($path[0], 8));
        }
        
        $basePath = APPLICATION_PATH;
        if ($moduleName) {
            $basePath .= '/modules/' . $moduleName;
        }
        
        $this->_controllerName = $controllerName;
        
        $basePath .= '/views/';
        if (!file_exists($basePath) || !is_dir($basePath)) {
            require_once 'Zend/Controller/Exception.php';
            throw new \Zend_Controller_Exception(
                'Missing base view directory ("' . $basePath . '")'
            );
        }
        require_once 'Zend/View.php';
        $this->_view = new \Zend_View(array('basePath' => $basePath));
        
        $this->_viewScript = $this->_controllerName . "/$viewName.phtml";
    }
    
    /**
     * Assigns a value to a view variable
     *
     * @param string $var 
     * @param string $value
     */
    public function assign($var, $value)
    {
        $this->_view->assign($var, $value);
    }
    
    /**
     * Added Zend matchers to interceptor before returning it
     * 
     * @param mixed
     * @return \PHPSpec\Specification\Interceptor
     */
    public function spec()
    {
        $interceptor = call_user_func_array(
            array(
                '\PHPSpec\Specification\Interceptor\InterceptorFactory',
                'create'),
            func_get_args()
        );
        $interceptor->addMatchers(array('contain', 'haveSelector'));
        return $interceptor;
    }
    
    /**
     * Renders the view
     */
    public function render()
    {
        $this->rendered = $this->spec($this->_view->render($this->_viewScript));
    }
    
}