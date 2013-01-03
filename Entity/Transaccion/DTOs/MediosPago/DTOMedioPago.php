<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago;

/**
 * @author gcaseres
 */
abstract class DTOMedioPago
{

    private $monto;

    public function __construct($monto)
    {
        $this->setMonto($monto);
    }
    
    public function setMonto($value)
    {
        $this->monto = $value;
    }
    
    public function getMonto()
    {
        return $this->monto;
    }
    
    
    public abstract function accept(IDTOMedioPagoVisitor $visitor);

}
