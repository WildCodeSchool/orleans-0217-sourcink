<?php
/**
 * Created by PhpStorm.
 * User: wilder2
 * Date: 08/06/17
 * Time: 11:19
 */

namespace UserBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}