<?php

namespace Snappminds\ContableBundle\Tests\Mocks;

use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

class CuentaRepositoryMock implements \Snappminds\ContableBundle\Entity\Cuenta\ICuentaRepository
{
    public function getCaja()
    {
        return new Cuenta('Caja');
    }
}