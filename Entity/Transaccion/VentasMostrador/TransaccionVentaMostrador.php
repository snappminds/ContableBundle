<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\VentasMostrador;

use Snappminds\ContableBundle\Entity\Transaccion\Transaccion;
use \Snappminds\ContableBundle\Entity\PlanDeCuenta\PlanDeCuenta;
use Snappminds\ContableBundle\Entity\Operacion\Operacion;

use Snappminds\ContableBundle\Entity\Transaccion\VentasMostrador\DTOs\DTOTransaccionVentaMostrador;

use Snappminds\ContableBundle\Entity\Cuenta\ICuentaRepository;

/**
 * @author ldelia
 */
class TransaccionVentaMostrador extends Transaccion
{
   
    public function __construct(ICuentaRepository $cuentasRepository, DTOTransaccionVentaMostrador $dto)
    {
        parent::__construct($cuentasRepository);
        $this->initialize($dto);
    }
    

    protected function initialize(DTOTransaccionVentaMostrador $dto)
    {        
        $operacionGenerator = new OperacionMedioPagoGenerator($this->getCuentasRepository()->getCaja());
        
        foreach ($dto->getPagos() as $dtoMedioPago) {
            $this->addOperacion($operacionGenerator->generate($dtoMedioPago));
        }
    }

}
