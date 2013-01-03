<?php

namespace Snappminds\ContableBundle\Entity\Transaccion;

use Snappminds\ContableBundle\Entity\Operacion\Operacion;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\PlanDeCuenta;
use Snappminds\ContableBundle\Entity\Cuenta\ICuentaRepository;

/**
 * @author ldelia
 */
abstract class Transaccion
{
    protected $cuentasRepository;
    protected $operaciones;

    public function __construct(ICuentaRepository $cuentasRepository)
    {
        $this->setCuentasRepository($cuentasRepository);
        $this->setOperaciones(new \ArrayObject());
    }

    protected function setCuentasRepository(ICuentaRepository $value)
    {
        $this->cuentasRepository = $value;
    }

    protected function getCuentasRepository()
    {
        return $this->cuentasRepository;
    }

    protected function setOperaciones($value)
    {
        $this->operaciones = $value;
    }

    protected function getOperaciones()
    {
        return $this->operaciones;
    }

    protected function addOperacion(Operacion $operacion)
    {
        $this->operaciones[] = $operacion;
    }

    public function execute()
    {
        $asientos = new \ArrayObject();
        foreach ($this->getOperaciones() as $operacion) {
            $asientos[] = $operacion->execute();
        }

        return $asientos;
    }

}
