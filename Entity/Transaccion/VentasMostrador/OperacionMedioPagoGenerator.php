<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\VentasMostrador;

use \Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago\DTOMedioPago;
use \Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago\IDTOMedioPagoVisitor;
use \Snappminds\ContableBundle\Entity\Operacion\VentasMostrador\OperacionVentaEfectivoMostrador;
use \Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

class OperacionMedioPagoGenerator implements IDTOMedioPagoVisitor
{
    private $cuentaCaja;
    
    public function __construct(Cuenta $cuentaCaja)
    {
        $this->setCuentaCaja($cuentaCaja);
    }
    
    protected function setCuentaCaja(Cuenta $value)
    {
        $this->cuentaCaja = $value;
    }
    
    protected function getCuentaCaja()
    {
        return $this->cuentaCaja;
    }
    
    public function generate(DTOMedioPago $dto)
    {
        return $dto->accept($this);
    }

    public function visitDTOEfectivo(DTOMedioPago $dto)
    {
        return new OperacionVentaEfectivoMostrador(
                $dto->getMonto(), 
                $this->getCuentaCaja(),
                $dto->getCuentaCliente()
        );
    }

    public function visitDTOCheque(DTOMedioPago $dto)
    {
        return null;
    }

}