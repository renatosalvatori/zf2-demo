<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureApiTest\Listener;

use ApplicationFeatureApi\Exception\MethodNotAllowedException;
use ApplicationFeatureApi\Listener\ResolveExceptionToJsonModelListener;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ResolveExceptionToJsonModelListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResolveExceptionToJsonModelListener
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new ResolveExceptionToJsonModelListener();
    }

    public function testOnError_WithoutError()
    {
        $event = new MvcEvent();

        $result = $this->testedObject->onError($event);

        $this->assertTrue($result);
    }

    public function testOnError_WithoutException()
    {
        $event = new MvcEvent();
        $event->setError('Some error message');

        $result = $this->testedObject->onError($event);

        $this->assertTrue($result);
    }

    public function testOnError_WithExceptionButNotFromApi()
    {
        $event = new MvcEvent();
        $event->setError('Some error message');
        $event->setParam('exception', new \InvalidArgumentException());

        $result = $this->testedObject->onError($event);

        $this->assertTrue($result);
    }

    public function testOnError_WithApiException()
    {
        $event = new MvcEvent();
        $event->setError("The resource doesn't support the specified HTTP verb.");
        $event->setParam('exception', new MethodNotAllowedException());
        $event->setResponse(new Response());

        $result = $this->testedObject->onError($event);

        $this->assertInstanceOf(JsonModel::class, $result);
    }
}