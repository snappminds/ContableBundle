<?php

namespace Snappminds\ContableBundle\Tests\PlanDeCuenta;

use Snappminds\Utils\Bundle\BluesBundle\Tests\Util\ModelDrivenTest;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\PlanDeCuenta;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlanAgrupamiento;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlanCuenta;
use \Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

class PlanDeCuentaTest extends ModelDrivenTest {

    protected function createCuenta($nombre) {
        return new Cuenta($nombre);
    }

    protected function createPlanDeCuenta() {
        return new PlanDeCuenta("Plan 1");
    }

    public function testAddItemAgrupamientoRaiz() {
        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Item de agrupamiento');
    }

    public function testAddItemCuentaRaiz() {
        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Item de cuenta', $this->createCuenta('Caja'));
    }

    public function testAddItemInterno() {
        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Item de agrupamiento 1');
        $plan->addItem('1.1', 'Item de agrupamiento 1.1');
        $plan->addItem('1.1.1', 'Item de cuenta 1.1.1', $this->createCuenta('Cuenta 1.1.1'));
        $plan->addItem('1.1.2', 'Item de cuenta 1.1.2', $this->createCuenta('Cuenta 1.1.2'));
        $plan->addItem('1.2', 'Item de agrupamiento 1.2');
        $plan->addItem('2', 'Item de agrupamiento 2');
        $plan->addItem('2.1', 'Item de agrupamiento 2.1');
        $plan->addItem('2.1.1', 'Item de cuenta 2.1.1', $this->createCuenta('Cuenta 2.1.1'));
    }

    public function testIterator() {

        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Item de agrupamiento 1');
        $plan->addItem('1.1', 'Item de agrupamiento 1.1');
        $plan->addItem('1.1.1', 'Item de cuenta 1.1.1', $this->createCuenta('Cuenta 1.1.1'));
        $plan->addItem('1.1.2', 'Item de cuenta 1.1.2', $this->createCuenta('Cuenta 1.1.2'));
        $plan->addItem('1.2', 'Item de cuenta 1.2', $this->createCuenta('Cuenta 1.2'));
        $plan->addItem('2', 'Item de agrupamiento 2');
        $plan->addItem('2.1', 'Item de agrupamiento 2.1');
        $plan->addItem('2.1.1', 'Item de cuenta 2.1.1', $this->createCuenta('Cuenta 2.1.1'));


        $planIterator = $plan->getIterator();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('1', $planIterator->current()->getCodigo());
        $this->assertEquals('1', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('1.1', $planIterator->current()->getCodigo());
        $this->assertEquals('1.1', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('1.1.1', $planIterator->current()->getCodigo());
        $this->assertEquals('1.1.1', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('1.1.2', $planIterator->current()->getCodigo());
        $this->assertEquals('1.1.2', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('1.2', $planIterator->current()->getCodigo());
        $this->assertEquals('1.2', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('2', $planIterator->current()->getCodigo());
        $this->assertEquals('2', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('2.1', $planIterator->current()->getCodigo());
        $this->assertEquals('2.1', $planIterator->key());

        $planIterator->next();

        $this->assertEquals(true, $planIterator->valid());
        $this->assertEquals('2.1.1', $planIterator->current()->getCodigo());
        $this->assertEquals('2.1.1', $planIterator->key());
    }

    public function testGetItem() {
        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Item de agrupamiento 1');
        $plan->addItem('1.1', 'Item de agrupamiento 1.1');
        $plan->addItem('1.1.1', 'Item de cuenta 1.1.1', $this->createCuenta('Cuenta 1.1.1'));
        $plan->addItem('1.1.2', 'Item de cuenta 1.1.2', $this->createCuenta('Cuenta 1.1.2'));
        $plan->addItem('1.1.2.1', 'Item de cuenta 1.1.2.1', $this->createCuenta('Cuenta 1.1.2.1'));
        $plan->addItem('1.2', 'Item de agrupamiento 1.2');
        $plan->addItem('2', 'Item de agrupamiento 2');
        $plan->addItem('2.1', 'Item de agrupamiento 2.1');
        $plan->addItem('2.1.1', 'Item de cuenta 2.1.1', $this->createCuenta('Cuenta 2.1.1'));

        $item = $plan->getItem('1.1.2');

        $this->assertEquals('1.1.2', $item->getCodigo());

        $item = $plan->getItem('1.2');

        $this->assertEquals('1.2', $item->getCodigo());
    }

    public function testGetItemRaiz() {
        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Activo');

        $item = $plan->getItem('1');

        $this->assertEquals('1', $item->getCodigo());
    }

    public function testInsert() {
        $em = $this->getEm();
        
        $plan = $this->createPlanDeCuenta();
        
        $cuenta1= $this->createCuenta('Cuenta 1.1.1');
        $cuenta2 = $this->createCuenta('Cuenta 1.1.2');
        $cuenta21 = $this->createCuenta('Cuenta 2.1.1');

        $plan->addItem('1', 'Item de agrupamiento 1');
        $plan->addItem('1.1', 'Item de agrupamiento 1.1');
        $plan->addItem('1.1.1', 'Item de cuenta 1.1.1', $cuenta1);
        $plan->addItem('1.1.2', 'Item de cuenta 1.1.2', $cuenta2);
        $plan->addItem('1.2', 'Item de agrupamiento 1.2');
        $plan->addItem('2', 'Item de agrupamiento 2');
        $plan->addItem('2.1', 'Item de agrupamiento 2.1');
        $plan->addItem('2.1.1', 'Item de cuenta 2.1.1', $cuenta21);
        
        $em->persist($cuenta1);
        $em->persist($cuenta2);
        $em->persist($cuenta21);
        
        
        $em->persist($plan);
        
        $em->flush();
        
    }

    public function testAddSubItem() {
        $plan = $this->createPlanDeCuenta();

        $plan->addItem('1', 'Item de agrupamiento 1');
        $plan->addItem('1.1', 'Item de agrupamiento 1.1');
        $plan->addItem('1.1.1', 'Item de cuenta 1.1.1', $this->createCuenta('Cuenta 1.1.1'));
        $plan->addItem('1.1.2', 'Item de cuenta 1.1.2', $this->createCuenta('Cuenta 1.1.2'));
        $plan->addItem('1.2', 'Item de agrupamiento 1.2');
        $plan->addItem('2', 'Item de agrupamiento 2');
        $plan->addItem('2.1', 'Item de agrupamiento 2.1');
        $plan->addItem('2.1.1', 'Item de agrupamiento 2.1.1');
        $plan->addItem('2.1.2', 'Item de agrupamiento 2.1.2');
        $plan->addSubItem('2.1', 'Item de agrupamiento Dinamico', $this->createCuenta('Cuenta 2.1.x') );

        $itemPadre = $plan->getItem('2.1');                
        $this->assertEquals('3', $itemPadre->getSubItems()->count() );
        
        $item = $plan->getItem('2.1.3');        
        $this->assertEquals('Item de agrupamiento Dinamico', $item->getDescripcion() );
    }
    
}
