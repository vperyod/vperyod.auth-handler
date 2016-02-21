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
 * @category  Trait
 * @package   Vperyod\AuthHandler
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/vperyod/vperyod.auth-handler
 */

namespace Vperyod\AuthHandler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Aura\Auth\Auth;

/**
 * Auth Request aware trait
 *
 * Trait for objects which need to know where the auth attribute is stored in
 * the request.
 *
 * @category Trait
 * @package  Vperyod\AuthHandler
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/2016 MIT License
 * @link     https://github.com/vperyod/vperyod.auth-handler
 */
trait AuthRequestAwareTrait
{
    /**
     * Attribute on request where auth is stored
     *
     * @var string
     *
     * @access protected
     */
    protected $authAttribute = 'aura/auth:auth';

    /**
     * Set auth attribute
     *
     * @param string $attr attribute on request where auth is stored
     *
     * @return $this
     *
     * @access public
     */
    public function setAuthAttribute($attr)
    {
        $this->authAttribute = $attr;
        return $this;
    }

    /**
     * Get auth from request
     *
     * @param Request $request PSR7 Request
     *
     * @return Auth
     * @throws InvalidArgumentException if auth attroibute is not an `Auth`
     *
     * @access protected
     */
    protected function getAuth(Request $request)
    {
        $auth = $request->getAttribute($this->authAttribute);
        if (! $auth instanceof Auth) {
            throw new \InvalidArgumentException(
                'Auth attribute not available in request'
            );
        }
        return $auth;
    }

    /**
     * Get auth status from request
     *
     * @param Request $request PSR7 Request
     *
     * @return string
     *
     * @access protected
     */
    protected function getAuthStatus(Request $request)
    {
        return $this->getAuth($request)->getStatus();
    }

    /**
     * Is auth status valid?
     *
     * @param Request $request PSR7 Request
     *
     * @return bool
     *
     * @access protected
     */
    protected function isAuthValid(Request $request)
    {
        return $this->getAuth($request)->isValid();
    }
}
