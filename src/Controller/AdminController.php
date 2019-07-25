<?php


namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\Entity\Users as User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends BaseAdminController
{
    public function createNewUserEntity(User $user, UserPasswordEncoderInterface $encoder)
    {
        /*
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
*/

        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }

    protected function prePersistUserEntity(User $user, UserPasswordEncoderInterface $encoder)
    {
        /*
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
*/
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }

    protected function preUpdateUserEntity(User $user, UserPasswordEncoderInterface $encoder)
    {
        if (!$user->getPassword()) {
            return;
        }
        /*
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
        */
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }

    private function encodePassword($user, $password)
    {
        $passwordEncoderFactory = $this->get('security.encoder_factory');
        $encoder = $passwordEncoderFactory->getEncoder($user);
        return $encoder->encodePassword($password, '');
    }

}
