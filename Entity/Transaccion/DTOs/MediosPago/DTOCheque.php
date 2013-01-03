<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago;

/**
 * @author gcaseres
 */
class DTOCheque extends DTOMedioPago
{

    public function __construct($monto)
    {
        parent::__construct($monto);
    }

    public function accept(IDTOMedioPagoVisitor $visitor)
    {
        return $visitor->visitDTOCheque($this);
    }

}
