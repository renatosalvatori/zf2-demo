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

namespace ApplicationFeatureAccessTest\Controller;

use ApplicationFeatureAccess\Controller\LoginController;
use ApplicationFeatureAccess\Form\LoginForm;
use ApplicationFeatureAccess\Service\LoginService;
use ApplicationLibraryTest\Controller\AbstractControllerTestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Form\ElementInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Parameters;

class LoginControllerTest extends AbstractControllerTestCase
{
    /**
     * @var LoginController
     */
    protected $controller;

    /**
     * @var MockObject
     */
    private $loginFormMock;

    /**
     * @var MockObject
     */
    private $loginService;

    public function setUp()
    {
        $this->init('login');

        $this->loginFormMock = $this->getMockBuilder(LoginForm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loginService = $this->getMockBuilder(LoginService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new LoginController($this->loginFormMock, $this->loginService);
        $this->controller->setEvent($this->event);
        $this->controller->getPluginManager()->setServiceLocator(Bootstrap::getServiceManager());
    }

    public function testAction_WithGetRequest()
    {
        $this->loginService->expects($this->never())
            ->method('login');

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['form' => $this->loginFormMock], $result);
    }

    public function testAction_WithValidPostRequest()
    {
        $data = [
            'login' => uniqid('login'),
            'password' => uniqid('password'),
            'csrf' => 'csrfToken'
        ];

        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->loginFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->loginFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->loginFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $this->loginService->expects($this->once())
            ->method('login')
            ->with($inputFilterMock)
            ->will($this->returnValue(true));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/');
    }

    public function testAction_WithInValidPostRequest()
    {
        $data = [
            'login' => uniqid('incorrectLogin'),
            'password' => uniqid('incorrectPassword'),
            'csrf' => 'incorrectCsrfToken'
        ];

        $this->loginFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->loginFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(false));

        $elementMock = $this->getMockBuilder(ElementInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $elementMock->expects($this->once())
            ->method('setValue')
            ->with(null);

        $this->loginFormMock->expects($this->once())
            ->method('get')
            ->with('password')
            ->will($this->returnValue($elementMock));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertNotRedirect();
    }

    public function testAction_WithExceptionInService()
    {
        $data = [
            'login' => uniqid('login'),
            'password' => uniqid('password'),
            'csrf' => 'csrfToken'
        ];

        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->loginFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->loginFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->loginFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $this->loginService->expects($this->once())
            ->method('login')
            ->with($inputFilterMock)
            ->will($this->throwException(new \Exception('Some exception')));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertNotRedirect();
    }

    public function testAction_WhenLoginIsFailed()
    {
        $data = [
            'login' => uniqid('login'),
            'password' => uniqid('password'),
            'csrf' => 'csrfToken'
        ];

        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->loginFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->loginFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->loginFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $elementMock = $this->getMockBuilder(ElementInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $elementMock->expects($this->once())
            ->method('setValue')
            ->with(null);

        $this->loginFormMock->expects($this->once())
            ->method('get')
            ->with('password')
            ->will($this->returnValue($elementMock));

        $this->loginService->expects($this->once())
            ->method('login')
            ->with($inputFilterMock)
            ->will($this->returnValue(false));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertNotRedirect();
    }

    public function testAction_WhenUserIsLogged()
    {
        $this->authenticateUser();

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_GET)
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/');
    }

}