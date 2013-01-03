<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\VentasMostrador\DTOs;

use Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago\DTOMediopago;

/**
 * @author gcaseres
 */
class DTOTransaccionVentaMostrador
{    
    private $pagos;
    
    public function __construct()
    {
        $this->setPagos(new \ArrayObject());
    }
    
    protected function setPagos(\ArrayObject $value)
    {
        $this->pagos = $value;
    }
    
    protected function getPagosCollection()
    {
        return $this->pagos;
    }
    
    public function addPago(DTOMedioPago $dtoMedioPago)
    {
        $this->getPagosCollection()->append($dtoMedioPago);
    }
    
    public function getPagos()
    {
        return $this->getPagosCollection()->getIterator();
    }
}
