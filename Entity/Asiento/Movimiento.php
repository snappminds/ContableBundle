<?php

namespace Snappminds\ContableBundle\Entity\Asiento;

use Doctrine\ORM\Mapping as ORM;
use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

/**
 * @ORM\Entity
 * @author ldelia
 */
class Movimiento
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $id;  
        
    /**
     * @ORM\ManyToOne(targetEntity="Snappminds\ContableBundle\Entity\Cuenta\Cuenta")      
     */            
    private $debe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Snappminds\ContableBundle\Entity\Cuenta\Cuenta")      
     */            
    private $haber;
    
    /** 
     * @ORM\Column(type="decimal")
     */     
    private $monto;
    
    
    public function __construct(Cuenta $debe, Cuenta $haber, $monto)
    {
        $this->debe = $debe;
        $this->haber = $haber;
        $this->monto = $monto;
    }
    
    public function getId()
    {
        return $this->id;
    }

    /*
     * @return Snappminds\ContableBundle\Entity\Cuenta\Cuenta
     */
    public function getDebe()
    {
        return $this->debe;
    }

    /*
     * @return Snappminds\ContableBundle\Entity\Cuenta\Cuenta
     */    
    public function getHaber()
    {
        return $this->haber;
    }

    public function getMonto()
    {
        return $this->monto;
    }
}
