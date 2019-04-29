<?php
// @codingStandardsIgnoreFile

namespace Vperyod\AuthHandler;

use Aura\Auth\Auth;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class AuthRequestTest extends TestCase
{
    protected $auth;

    public function testTriat()
    {
        $auth = $this->getMockBuilder(Auth::class)
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
        $this->ExpectException('InvalidArgumentException');
        $req = ServerRequestFactory::fromGlobals();
        $fake = new Fake\FakeAuthRequestAware;
        $fake->proxyGetAuth($req);
    }
}
