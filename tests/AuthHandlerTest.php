<?php
// @codingStandardsIgnoreFile

namespace Vperyod\AuthHandler;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class AuthHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $auth;

    public function testHandler()
    {
        $this->auth = $this->getMockBuilder('Aura\Auth\Auth')
            ->disableOriginalConstructor()
            ->getMock();

        $resume = $this->getMockBuilder('Aura\Auth\Service\ResumeService')
            ->disableOriginalConstructor()
            ->getMock();

        $resume->expects($this->once())
            ->method('resume')
            ->with($this->auth);

        $handler = new AuthHandler($this->auth, $resume);
        $handler->setAuthAttribute('auth');

        $handler(
            ServerRequestFactory::fromGlobals(),
            new Response(),
            [$this, 'checkRequest']
        );
    }

    public function checkRequest($request, $response)
    {
        $this->assertSame(
            $this->auth,
            $request->getAttribute('auth')
        );

        return $response;
    }
}
