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
namespace PHPSpec\Context\Symfony2;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use \PHPSpec\Context,
    \PHPSpec\Util\Filter;

require_once __DIR__ . '/../../../../../../app/bootstrap.php.cache';
require_once __DIR__ . '/../../../../../../app/AppKernel.php';

//vendor/phpspec-symfony2/src/PHPSpec/Context/Symfony2/
/**
 * @category   PHPSpec
 * @package    PHPSpec_Zend
 * @copyright  Copyright (c) 2007-2009 Pádraic Brady, Travis Swicegood
 * @copyright  Copyright (c) 2010-2011 Pádraic Brady, Travis Swicegood,
 *                                     Marcello Duarte
 *                                     Luis Cordova
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public Licence Version 3
 */
class View extends Context
{
    private $templating;
    
    /**
     * Creates the view context
     */
    public function __construct()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->loadClassCache();
        $kernel->init();
        $kernel->boot();
        $templatingService = $kernel->getContainer()->get('templating');

        // Some variables
        $this->setTemplating($templatingService);
    }

    /**
     * sets template engine
     *
     * @param EngineInterface
     */
    public function setTemplating(EngineInterface $templating) {
        $this->templating = $templating;
    }

    /*
     * Added Symfony matchers to interceptor before returning it
     *
     * @param mixed
     * @return \PHPSpec\Specification\Interceptor
     */
    public function spec()
    {
        $interceptor = call_user_func_array(
            array(
                '\PHPSpec\Specification\Interceptor\InterceptorFactory',
                'create'
            ),
            func_get_args()
        );

        $interceptor->addMatchers(array('contain', 'haveSelector'));
        return $interceptor;
    }

    /**
     * Renders the view
     */
    public function render($template, array $templateContext = array())
    {
        if (is_null($this->templating)) {
            throw new \LogicException('No templating engine set.');
        }

        return $this->spec($this->templating->render($template, $templateContext));
    }

}