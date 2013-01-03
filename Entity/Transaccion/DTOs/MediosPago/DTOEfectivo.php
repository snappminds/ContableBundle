<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago;

use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

/**
 * @author gcaseres
 */
class DTOEfectivo extends DTOMedioPago
{

    private $cuentaCliente;
    
    public function __construct($monto, Cuenta $cuentaCliente)
    {
        parent::__construct($monto);        
        $this->setCuentaCliente($cuentaCliente);
    }
    
    
    public function setCuentaCliente(Cuenta $value)
    {
        $this->cuentaCliente = $value;
    }
    
    public function getCuentaCliente()
    {
        return $this->cuentaCliente;
    }
    
    public function accept(IDTOMedioPagoVisitor $visitor)
    {
        return $visitor->visitDTOEfectivo($this);
    }

}
