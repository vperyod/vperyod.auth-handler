<?php
// @codingStandardsIgnoreFile

namespace Vperyod\AuthHandler;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class AuthRequestTest extends \PHPUnit_Framework_TestCase
{
    protected $auth;

    public function testTriat()
    {
        $auth = $this->getMockBuilder('Aura\Auth\Auth')
            ->disableOriginalConstructor()
            ->getMock();

        $auth->expects($this->once())
            ->method('getStatus')
            ->will($this->returnValue('foo'));

        $auth->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $req = ServerRequestFactory::fromGlobals()
            ->withAttribute('auth', $auth);

        $fake = new Fake\FakeAuthRequestAware;

        $fake->setAuthAttribute('auth');

        $this->assertSame($auth, $fake->proxyGetAuth($req));
        $this->assertSame('foo', $fake->proxyGetStatus($req));
        $this->assertTrue($fake->proxyIsValid($req));
    }

    public function testError()
    {
        $this->setExpectedException('InvalidArgumentException');

        $req = ServerRequestFactory::fromGlobals();

        $fake = new Fake\FakeAuthRequestAware;

        $fake->proxyGetAuth($req);
    }
}
