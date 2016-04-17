<?php
// @codingStandardsIgnoreFile

namespace Vperyod\AuthHandler\Fake;

use Vperyod\AuthHandler\AuthRequestAwareTrait;

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
