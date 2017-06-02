<?php

namespace SI\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SIUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
