<?php

namespace Snappminds\ContableBundle\Entity\PlanDeCuenta;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ItemPlan" = "ItemPlan", "ItemPlanCuenta" = "ItemPlanCuenta"})
 * @author ldelia
 */
class ItemPlan
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */            
    protected $descripcion;
    
    /**
     * @ORM\Column(type="string", length=100)
     */            
    protected $codigo;
    
    /**
     * @ORM\ManyToOne( targetEntity="Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlan")  
     */    
    protected $padre;
    
    /**
     * @ORM\OneToMany(indexBy="codigo", targetEntity="Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlan", mappedBy="padre", cascade={"persist"})  
     */        
    protected $subItems;

    public function __construct( $codigo, $descripcion )
    {
        $this->setDescripcion($descripcion);
        $this->setCodigo($codigo);        
        $this->subItems = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }    
    
    public function getPadre()
    {
        return $this->padre;
    }
    
    public function setPadre(ItemPlan $padre)
    {
        $this->padre = $padre;
    }    

    public function getSubItem($codigo)
    {
        return $this->subItems[$codigo];
    }
    
    public function getSubItems()
    {
        return $this->subItems;
    }
    
    public function addSubItem(ItemPlan $item)
    {
        $codigo = $item->getCodigo();
        $item->setPadre($this);
        
        if (isset($this->subItems[$codigo]))
            throw new \Exception('El código especificado ya existe.');
        else
            $this->subItems[$codigo] = $item;
    }
    
}
