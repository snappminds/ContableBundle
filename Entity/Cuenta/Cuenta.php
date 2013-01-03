<?php

namespace Snappminds\ContableBundle\Entity\Cuenta;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Snappminds\ContableBundle\Entity\Cuenta\CuentaRepository")
 * @author ldelia
 */
class Cuenta
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */    
    private $descripcion;
    
    public function __construct($descripcion)
    {
        $this->setDescripcion($descripcion);
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }    
}
