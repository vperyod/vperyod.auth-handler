<?php
/**
 * Authentication Handler
 *
 * PHP version 7
 *
 * Copyright (C) 2019 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  Middleware
 * @package   Vperyod\AuthHandler
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2019 Jake Johns
 * @license   http://jnj.mit-license.org/2019 MIT License
 * @link      https://github.com/vperyod/vperyod.auth-handler
 */

namespace Vperyod\AuthHandler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;

use Aura\Auth\Auth;
use Aura\Auth\Service\ResumeService as Resume;

/**
 * AuthHandler
 *
 * @category Middleware
 * @package  Vperyod\AuthHandler
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2019 MIT License
 * @link     https://github.com/vperyod/vperyod.auth-handler
 */
class AuthHandler implements MiddlewareInterface
{
    use AuthRequestAwareTrait;

    /**
     * Resume
     *
     * @var Resume
     *
     * @access protected
     */
    protected $resume;

    /**
     * Auth
     *
     * @var Auth
     *
     * @access protected
     */
    protected $auth;

    /**
     * __construct
     *
     * @param Auth   $auth   Aura\Auth current user representation
     * @param Resume $resume Aura\Auth Resume service
     *
     * @access public
     */
    public function __construct(Auth $auth, Resume $resume)
    {
        $this->auth   = $auth;
        $this->resume = $resume;
    }

    /**
     * Resume
     *
     * @return Auth
     *
     * @access protected
     */
    protected function resume() : Auth
    {
        $this->resume->resume($this->auth);
        return $this->auth;
    }

    /**
     * Resumes Authenticated Session
     *
     * @param Request  $request  PSR7 HTTP Request
     * @param Handler  $handler  Next handler 
     *
     * @return Response
     *
     * @access public
     */
    public function process(Request $request, Handler $handler): Response
    {
        $request = $request->withAttribute(
            $this->authAttribute,
            $this->resume()
        );
        return $handler->handle($request);
    }
}
