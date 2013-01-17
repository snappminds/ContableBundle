<?php
namespace Snappminds\ContableBundle\Entity\PlanDeCuenta;

class PlanDeCuentaIterator implements \Iterator
{
    private $raices;
    private $valid;
    private $current;
    private $itemIteratorStack;
    private $parentItemSubItemsIterator;
    
    public function __construct($raices) 
    {
		// FIX 17/01/2013 (ldelia)
		// Cuando se utiliza el iterador, en un ambiente en memoria, como por ejemplo un test case
		// raices es un simple array y por lo tanto necesito pasarlo a ArrayObject
		// Cuadno se utiliza el iterador, en un ambiente con persistencia, raices ya es objecto Doctrine\ORM\PersistentCollection
        if ( ! is_object( $raices ) ) {
            $raices = new \ArrayObject($raices);    
        }
        $this->setRaices($raices);
        $this->setParentItemSubItemsIterator($raices->getIterator());
        $this->rewind();        
    }

    protected function setValid($value)
    {
        $this->valid = $value;
    }

    protected function getValid()
    {
        return $this->valid;
    }

    protected function setCurrent($value)
    {
        $this->current = $value;
    }

    protected function getCurrent()
    {
        return $this->current;
    }
    
    protected function setRaices($value)
    {
        $this->raices = $value;
    }
    
    protected function getRaices()
    {
        return $this->raices;
    }

    protected function setItemIteratorStack($value)
    {
        $this->itemIteratorStack = $value;
    }
    
    protected function getItemIteratorStack()
    {
        return $this->itemIteratorStack;
    }
    
    protected function setParentItemSubItemsIterator($value)
    {
        $this->parentItemSubItemsIterator = $value;
    }
    
    protected function getParentItemSubItemsIterator()
    {
        return $this->parentItemSubItemsIterator;
    }
    
    public function current()
    {
        if (!$this->valid())
            throw new \Exception('No se pudo obtener el elemento.');
        else
            return $this->getCurrent();
    }
    
    public function key()
    {
        if ($this->valid()) {
            return $this->getCurrent()->getCodigo();
        }
    }
    
    public function next()
    {
        if (!$this->valid())
            return;
        
        $this->getItemIteratorStack()->push($this->getParentItemSubitemsIterator());            
        $this->setParentItemSubitemsIterator($this->getCurrent()->getSubItems()->getIterator());
        
        if ($this->getParentItemSubitemsIterator()->valid()) {
 
            $this->setCurrent($this->getParentItemSubitemsIterator()->current());
            $this->getParentItemSubitemsIterator()->next();
        } else {            
            do {
                $this->setParentItemSubitemsIterator($this->getItemIteratorStack()->pop());    
            } while ( ( $this->getItemIteratorStack()->count() > 0 ) && (! $this->getParentItemSubitemsIterator()->valid())  );            
            
            if ($this->getParentItemSubitemsIterator()->valid()) {                
                $this->setCurrent($this->getParentItemSubitemsIterator()->current());                
                $this->getParentItemSubitemsIterator()->next();
            } else {                
                $this->setValid(false);                
            }
        }
    }
    
    public function rewind()
    {
        $this->setParentItemSubitemsIterator($this->getRaices()->getIterator());
        $this->setValid($this->getParentItemSubItemsIterator()->valid());
        if ($this->getParentItemSubItemsIterator()->valid()) {
            $this->setCurrent($this->getParentItemSubItemsIterator()->current());        
            $this->getParentItemSubItemsIterator()->next();
        }
        $this->setItemIteratorStack(new \SplStack());        
    }
    
    public function valid()
    {
        return $this->getValid();
    }

}
