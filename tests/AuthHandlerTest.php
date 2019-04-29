<?php
// @codingStandardsIgnoreFile

namespace Vperyod\AuthHandler;

use Aura\Auth;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class AuthHandlerTest extends TestCase
{
    protected $auth;

    public function testHandler()
    {
        $this->auth = $this->getMockBuilder(Auth\Auth::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resume = $this->getMockBuilder(Auth\Service\ResumeService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resume->expects($this->once())
            ->method('resume')
            ->with($this->auth);

        $handler = new AuthHandler($this->auth, $resume);
        $handler->setAuthAttribute('auth');

        $handler->process(
            ServerRequestFactory::fromGlobals(),
            new class ($this, $this->auth) implements RequestHandlerInterface {
                protected $test;
                protected $auth;
                public function __construct($test, $auth){
                    $this->test = $test;
                    $this->auth = $auth;
                }
                function handle(ServerRequestInterface $request) : ResponseInterface {
                    $this->test->assertSame(
                        $this->auth,
                        $request->getAttribute('auth')
                    );
                    return new Response();
                }
            }
        );
    }
}
