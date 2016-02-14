<?php
/**
 * Authentication Handler
 *
 * PHP version 5
 *
 * Copyright (C) 2016 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  Middleware
 * @package   Jnjxp\AuthHandler
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.auth-handler
 */

namespace Jnjxp\AuthHandler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Aura\Auth\Auth;
use Aura\Auth\Service\ResumeService as Resume;

/**
 * AuthHandler
 *
 * @category Middleware
 * @package  Jnjxp\AuthHandler
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/jnjxp/jnjxp.auth-handler
 */
class AuthHandler
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
     * @return Aura\Auth\Auth
     *
     * @access protected
     */
    protected function resume()
    {
        $this->resume->resume($this->auth);
        return $this->auth;
    }

    /**
     * Resumes Authenticated Session
     *
     * @param Request  $request  PSR7 HTTP Request
     * @param Response $response PSR7 HTTP Response
     * @param callable $next     Next callable middleware
     *
     * @return Response
     *
     * @access public
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $request = $request->withAttribute(
            $this->authAttribute,
            $this->resume()
        );
        return $next($request, $response);
    }
}
