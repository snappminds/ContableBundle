<?php
namespace Snappminds\ContableBundle\Entity\PlanDeCuenta;

use Doctrine\ORM\Mapping as ORM;
use Snappminds\ContableBundle\Entity\Cuenta\Cuenta;

/**
 * @ORM\Entity
 * @author ldelia
 */
class PlanDeCuenta implements \IteratorAggregate
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
    private $nombre;
    
    /** 
     * @ORM\ManyToMany(indexBy="codigo", targetEntity="ItemPlan", cascade={"persist"}) 
     */    
    private $items;
    
    public function __construct( $nombre )
    {
        $this->setNombre($nombre);
    }
    
    public function getId()
    {
        return $this->id;
    }
        
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    protected function getItems()
    {
        return $this->items;
    }
    
    public function addItem($codigo, $descripcion, Cuenta $cuenta = null)
    {
        $this->validarCodigo($codigo);
        
        if ($cuenta == null)
            $this->addItemPlan($codigo, $descripcion);
        else
            $this->addItemCuenta($codigo, $descripcion, $cuenta);            
    }

    public function addSubItem($codigoItemPadre, $descripcion, Cuenta $cuenta = null)
    {
        $itemPadre = $this->getItem($codigoItemPadre);
        
        if( ! $itemPadre ) throw new \Exception("El código " . $codigoItemPadre . " no existe.");                    
                
        $maxValue = 0;
        
        foreach( $itemPadre->getSubItems() as $subItem ){
            $niveles = preg_split("/\./", $subItem->getCodigo() );
            $maxValue = max( $maxValue, $niveles[ count( $niveles ) -1  ] ) ;
        }
        
        $maxValue++;
        
        $codigoSubItem = $codigoItemPadre . "." . $maxValue;
        
        /**
         * TODO: planear distintos strategys para cuando el codigo no es numerico
         */
        
        $this->addItem($codigoSubItem, $descripcion, $cuenta);
    }
    
    public function addItemPlan($codigo, $descripcion)
    {
        $this->validarCodigo($codigo);
        
        $item = new ItemPlan($codigo, $descripcion);
        
        $this->InternalAddItem($item);
    }
    
    public function addItemCuenta($codigo, $descripcion, $cuenta)
    {
        $this->validarCodigo($codigo);
        
        $this->InternalAddItem(new ItemPlanCuenta($codigo, $descripcion, $cuenta));
    }   
    
    protected function InternalAddItem(ItemPlan $item)
    {
        $codigo = $item->getCodigo();
        $niveles = preg_split("/\./", $codigo);
        
        if (count($niveles) > 1) {
            $parent = $this->getItem(implode('.', array_slice($niveles, 0, count($niveles) - 1)));
            $parent->addSubItem($item);            
        } else {
            $this->addItemRaiz($item);
        }
    }
    
    /**
     * Devuelve un item del plan según un código
     * @return Snappminds\ContableBundle\Entity\PlanDeCuenta\ItemPlan
     */
    public function getItem($codigo)
    {
        $this->validarCodigo($codigo);
        
        /*
         * Se genera un arreglo de niveles, donde cada nivel
         * es una componente del código.
         */        
        $niveles = preg_split('/\./', $codigo);
        
        //Obtener el elemento raiz
        $item = $this->getItemRaiz($niveles[0]);
        
        //Quitar el primer nivel del arreglo de niveles
        $niveles = array_slice($niveles, 1, count($niveles) - 1);
        
        //Código del subitem a obtener.
        $codigoSubItem = $item->getCodigo();        
        
        //Se itera por los niveles restantes
        foreach ($niveles as $nivel) {
            $codigoSubItem .= '.' . $nivel;

            $item = $item->getSubItem($codigoSubItem);
        }
        
        return $item;
    }
    
    protected function validarCodigo($codigo)
    {
        //TODO: Validar con regex y levantar una excepción si es incorrecto
    }
    
    protected function getItemRaiz($codigo)
    {
        $this->validarCodigo($codigo);
        
        if (isset($this->items[$codigo]))
            return $this->items[$codigo];
        else 
            throw new \Exception("El código especificado no existe en el plan.");
    }
    
    public function addItemRaiz(ItemPlan $item)
    {
        if (isset($this->items[$item->getCodigo()]))
            throw new \Exception("El código especificado ya existe.");                    
        else 
            $this->items[$item->getCodigo()] = $item;
    }
    
    public function getIterator()
    {
        return new PlanDeCuentaIterator($this->getItems());
    }
    
}
