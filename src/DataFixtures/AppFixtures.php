<?php

namespace App\DataFixtures;

use App\Entity\FamilyProduct;
use App\Entity\OrderBack;
use App\Entity\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private $ordersStatus = ['En attente', 'En stock', 'Sortie'];

    private $familysProduct =['Parcelle', 'Colis'];

    private $orderBack = ['Retour complet', 'Retour partiel', 'Livraison tardive', 'Livraison express' ];


    public function load(ObjectManager $manager)
    {
        $this->addOrderStatus($manager);
        $this->addFamilyProduct($manager);
        $this->addOrderBack($manager);
    }

    public function addOrderStatus(ObjectManager $manager)
    {
        foreach ($this->ordersStatus as $orderStatus)
        {
            $order = new OrderStatus();
            $order->setName($orderStatus);
            $order->setEnable(true);
            $manager->persist($order);
        }
        $manager->flush();
    }

    public function addFamilyProduct(ObjectManager $manager)
    {
        foreach ($this->familysProduct as $familyProduct)
        {
            $family = new FamilyProduct();
            $family->setName($familyProduct);
            $manager->persist($family);
        }
        $manager->flush();
    }

    public function addOrderBack(ObjectManager $manager)
    {
        foreach ($this->orderBack as $orderBack)
        {
            $back = new OrderBack();
            $back->setName($orderBack);
            $back->setStatus(true);
            $manager->persist($back);
        }
        $manager->flush();
    }
}
