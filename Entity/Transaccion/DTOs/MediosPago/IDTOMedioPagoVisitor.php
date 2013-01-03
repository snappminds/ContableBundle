<?php

namespace Snappminds\ContableBundle\Entity\Transaccion\DTOs\MediosPago;

interface IDTOMedioPagoVisitor
{
    public function visitDTOEfectivo(DTOMedioPago $dto);
    public function visitDTOCheque(DTOMedioPago $dto);
}