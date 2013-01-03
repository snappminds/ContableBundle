<?php

namespace Snappminds\ContableBundle\Entity\Operacion;

/**
 * @author ldelia
 */
abstract class Operacion
{
    public function __construct()
    {
    }

    public abstract function execute();

}
