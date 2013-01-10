<?php

namespace Snappminds\ContableBundle\Entity\Asiento;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

/**
 * @ORM\Entity
 * @author ldelia
 */
class Asiento
{
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $id;  
    
    /**
     * @ORM\Column(type="datetime")
     */        
    private $fecha;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */            
    private $descripcion;
    
    /** 
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="listaDeArticulo", cascade={"persist","remove"}) 
     */        
    private $movimientos;
    
    public function __construct()
    {
        $this->setFecha(new \DateTime());
        $this->movimientos = new ArrayCollection();
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    
    public function addMovimiento(Cuenta $debe, Cuenta $haber, $monto) 
    {
        $this->movimientos[] = new Movimiento($debe, $haber, $monto, $this);
    }
    
    public function getMovimientos()
    {
        return $this->movimientos;
    }
}
