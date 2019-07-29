<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;


class RackExtension extends AbstractExtension
{



    public function getFilters()
    {
        return new TwigFilter('rack', array($this, 'transformRack'));
    }

    public function getFunctions()
    {
        return new TwigFunction('rack', array($this, 'transformRack'));
    }

    public function transformRack($emplacement)
    {
        $position = "En attente";

        if(!$emplacement == Null)
        {
            $rack = substr($emplacement, 3, 1);
            $alveole = substr($emplacement, 8, 2);
            $etage = substr($emplacement,-2);

            $position = $rack . "-" . $alveole . "-" . $etage;
        }

        return $position;

    }

    public function getName()
    {
        return 'rack_extension';
    }

}

