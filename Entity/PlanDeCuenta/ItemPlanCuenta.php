<?php

namespace Snappminds\ContableBundle\Entity\PlanDeCuenta;

use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @author ldelia
 */
class ItemPlanCuenta  extends ItemPlan
{    
    /**
     * @ORM\ManyToOne( targetEntity="Snappminds\ContableBundle\Entity\Cuenta\Cuenta")  
     */
    protected $cuenta;
    
    public function __construct( $codigo, $descripcion, Cuenta $cuenta )
    {
        parent::__construct($codigo, $descripcion); 
        $this->setCuenta($cuenta);
    }
    
    public function getCuenta()
    {
        return $this->cuenta;
    }

    public function setCuenta(Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    }

    public function accept (IItemPlanVisitor $visitor ) {
        return $visitor->visitItemPlanCuenta($this);
    }
    
}
