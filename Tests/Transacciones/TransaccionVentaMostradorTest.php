<?php

namespace Snappminds\ContableBundle\Tests\Transacciones;

use Snappminds\Utils\Bundle\BluesBundle\Tests\Util\ModelDrivenTest;
use Snappminds\ContableBundle\Entity\Transaccion as NSTransaccion;
use Snappminds\ContableBundle\Tests\Mocks\CuentaRepositoryMock;
use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;


class TransaccionVentaMostradorTest extends ModelDrivenTest
{    
    protected function getCuentasRepository()
    {
        return new CuentaRepositoryMock();
    }
    
    public function testExecuteTransaccion()
    {
        
        $cuentasRepository = $this->getCuentasRepository();
        
        $cuentaCliente = new Cuenta('Clientes');
        
        $dto = new NSTransaccion\VentasMostrador\DTOs\DTOTransaccionVentaMostrador();
        $dto->addPago(new NSTransaccion\DTOs\MediosPago\DTOEfectivo(100, $cuentaCliente));
        
        $transaccion = new NSTransaccion\VentasMostrador\TransaccionVentaMostrador(
                $cuentasRepository, 
                $dto
        );
        
        $asientos = $transaccion->execute();        
        
        $this->assertEquals(1, count($asientos), 
                "Se esperaba que se genere un asiento.");
        
        $movimientos = $asientos[0]->getMovimientos();
        
        $this->assertEquals(1, $movimientos->count(), 
                "El asiento generado debe tener dos movimientos.");
        
        $movimiento = $movimientos->current();
        
        $this->assertEquals(100, $movimiento->getMonto(), 
                "Se esperaba el valor 100 en el movimiento.");
        $this->assertEquals('Caja', $movimiento->getDebe()->getDescripcion(),
                "Se esperaba la cuenta Caja");

        $this->assertEquals('Clientes', $movimiento->getHaber()->getDescripcion(),
                "Se esperaba la cuenta Clientes");        
    }
}
