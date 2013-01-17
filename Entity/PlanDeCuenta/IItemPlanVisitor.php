<?php

namespace Snappminds\ContableBundle\Entity\PlanDeCuenta;

interface IItemPlanVisitor
{
    public function visitItemPlan(ItemPlan $itemPlan);
    public function visitItemPlanCuenta(ItemPlanCuenta $itemPlanCuenta);
}