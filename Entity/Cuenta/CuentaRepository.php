<?php

namespace Snappminds\ContableBundle\Entity\Cuenta;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CuentaRepository
 *
 * @author ldelia
 */

class CuentaRepository extends EntityRepository implements ICuentaRepository
{
    public function getCaja()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT c FROM \Snappminds\ContableBundle\Entity\Cuenta\Cuenta c WHERE c.descripcion = 'CAJA'")
            ->getSingleResult();
    }
}



