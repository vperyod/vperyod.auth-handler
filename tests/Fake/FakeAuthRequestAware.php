<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\AuthHandler\Fake;

use Jnjxp\AuthHandler\AuthRequestAwareTrait;

class FakeAuthRequestAware
{
    use AuthRequestAwareTrait;

    public function proxyGetAuth($request)
    {
        return $this->getAuth($request);
    }

    public function proxyGetStatus($request)
    {
        return $this->getAuthStatus($request);
    }

    public function proxyIsValid($request)
    {
        return $this->isAuthValid($request);
    }

}
