<?php
namespace XSolveSecurityBundle\InsertionAlghoritms;

use XSolveSecurityBundle\Entity\Resource;
use XSolveSecurityBundle\Models\Shelf;

interface InsertionAlgorithmsInterface {

    public function tableWitchNewElement(Shelf $shelf, Resource $resource);
}
