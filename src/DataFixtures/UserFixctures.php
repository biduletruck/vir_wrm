<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixctures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new Users();

        $user->setLastName('clement');
        $user->setFirstName('yann');
        $user->setEmail('yc@yc.com');
        $user->setUsername('yann');
        $user->setAccount('true');
        $user->setRoles(['ROLE_USER','ROLE_ADMIN']);
        $user->setPassword($this->encoder->encodePassword($user, 'demodemo'));
        $manager->persist($user);
        $manager->flush();
    }
}
