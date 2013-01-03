<?php

namespace Snappminds\ContableBundle\Entity\Operacion\VentasMostrador;

use \Snappminds\ContableBundle\Entity\Asiento\Asiento;
use \Snappminds\ContableBundle\Entity\Asiento\Movimiento;
use \Snappminds\ContableBundle\Entity\Operacion\Operacion;
use \Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

/**
 * @author ldelia
 */
class OperacionVentaEfectivoMostrador extends Operacion
{

    private $monto;
    private $cuentaCaja;
    private $cuentaClientes;

    public function __construct($monto, Cuenta $cuentaCaja, Cuenta $cuentaClientes)
    {
        $this->setMonto($monto);
        $this->setCuentaCaja($cuentaCaja);
        $this->setCuentaClientes($cuentaClientes);
    }

    public function setMonto($value)
    {
        $this->monto = $value;
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setCuentaCaja(Cuenta $value)
    {
        $this->cuentaCaja = $value;
    }

    public function getCuentaCaja()
    {
        return $this->cuentaCaja;
    }

    public function setCuentaClientes(Cuenta $value)
    {
        $this->cuentaClientes = $value;
    }

    public function getCuentaClientes()
    {
        return $this->cuentaClientes;
    }

    public function execute()
    {
        $asiento = new Asiento();
        $asiento->addMovimiento( $this->getCuentaCaja(), $this->getCuentaClientes(), $this->getMonto() );

        return $asiento;
    }

}
