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
namespace PHPSpec\Context;

use \PHPSpec\Context,
    \PHPSpec\Context\Symfony2\Symfony2Test;

class Symfony2 extends Context
{
    protected $_symfony2Test;
    public $module;
    public $controller;
    public $action;

    public function get($url = null)
    {
        $this->_dispatch($url);
    }

    public function post($url, array $params = array())
    {
        $this->_getSymfony2Test()->request->setMethod('POST')
             ->setPost($params);
        $this->_dispatch($url);
    }

    public function put($url, array $params = array())
    {
        $this->_getSymfony2Test()->request->setMethod('PUT')
             ->setPost($params);
        $this->_dispatch($url);
    }

    public function delete($url, array $params = array())
    {
        $this->_getSymfony2Test()->request->setMethod('DELETE')
             ->setPost($params);
        $this->_dispatch($url);
    }

    public function head($url, array $params = array())
    {
        $this->_getSymfony2Test()->request->setMethod('HEAD')
             ->setPost($params);
        $this->_dispatch($url);
    }

    public function routeFor($options)
    {
        return $this->spec($this->_getSymfony2Test()->url($options));
    }

    public function spec()
    {
        $interceptor = call_user_func_array(
            array(
                '\PHPSpec\Specification\Interceptor\InterceptorFactory',
                'create'),
            func_get_args()
        );
        $interceptor->addMatchers(array('redirect', 'redirectTo'));
        return $interceptor;
    }

    protected function _dispatch($url = null)
    {
        $this->_getSymfony2Test()->dispatch($url);
        $this->module = $this->spec($this->_getSymfony2Test()->request->getModuleName());
        $this->controller = $this->spec($this->_getSymfony2Test()->request->getControllerName());
        $this->action = $this->spec($this->_getSymfony2Test()->request->getActionName());
        $this->response = $this->spec($this->_getSymfony2Test()->response);
        $this->request = $this->spec($this->_getSymfony2Test()->request);
    }

    protected function _getSymfony2Test()
    {
        if ($this->_symfony2Test === null) {
            $this->_symfony2Test = new Symfony2Test;
        }
        return $this->_symfony2Test;
    }
}