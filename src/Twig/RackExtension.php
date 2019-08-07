<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class RackExtension extends AbstractExtension
{



    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('rack', array($this, 'transformRack')));
    }

    public function transformRack($emplacement)
    {
        $position = "En attente";

        if(!$emplacement == Null)
        {
            $rack = substr($emplacement, 3, 1);
            $alveole = substr($emplacement, 8, 2);
            $etage = substr($emplacement,-2);

          //  $position = $rack . "-" . $alveole . "-" . $etage;
            $position = "Allée : " . $rack . " / Lice : " . $etage . " / Alvéole : " . $alveole;
        }

        return $position;

    }

    public function getName()
    {
        return 'rack_extension';
    }

}

