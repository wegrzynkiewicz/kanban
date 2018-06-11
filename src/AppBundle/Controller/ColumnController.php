<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ColumnController extends Controller
{
    /**
     * @Route("/columns", name="columns")
     */
    public function getColumnsAction(Request $request)
    {
        return new JsonResponse([
            $this->addColumn(1, "Nowe zadania"),
            $this->addColumn(2, "W trakcie realizacji"),
            $this->addColumn(3, "Zakończone"),
            $this->addColumn(4, "Poprawki"),
        ]);
    }

    private function addColumn($type, $name)
    {
        return [
            "type" => $type,
            "name" => $name,
        ];
    }
}
