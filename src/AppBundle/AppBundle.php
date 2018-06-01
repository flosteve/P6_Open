<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AppBundle
 * @package AppBundle
 */
class AppBundle extends Bundle
{
    /**
     * @return null|string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
