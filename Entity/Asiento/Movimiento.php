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
     * @ORM\ManyToOne(targetEntity="Asiento", inversedBy="movimientos")
     */
    private $asiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Snappminds\ContableBundle\Entity\Cuenta\Cuenta")      
     */            
    private $debe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Snappminds\ContableBundle\Entity\Cuenta\Cuenta")      
     */            
    private $haber;
    
    /** 
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */     
    private $monto;
    
    
    public function __construct(Cuenta $debe, Cuenta $haber, $monto, Asiento $asiento)
    {
        $this->debe = $debe;
        $this->haber = $haber;
        $this->monto = $monto;
        $this->asiento = $asiento;
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
    
    public function getAsiento()
    {
        return $this->asiento;
    }    
}
