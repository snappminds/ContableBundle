<?php

namespace Snappminds\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\PlanDeCuenta;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlanAgrupamiento;
use Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlanCuenta;
use \Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

class DefaultController extends Controller {

    protected function createCuenta($nombre) {
        return new Cuenta($nombre);
    }

    protected function createPlanDeCuenta() {
        return new PlanDeCuenta("Plan 1");
    }
    
    public function arbolAction(){
        
         $plan = $this->getDoctrine()->getRepository('Snappminds\ContableBundle\Entity\PlanDeCuenta\PlanDeCuenta')->find(1);
         $planIterator = $plan->getIterator();
        
         var_dump($planIterator->valid());
         echo $planIterator->current()->getCodigo();
         
    }

}
