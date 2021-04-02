<?php


namespace App\Events\Doctrine;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\User\UserInterface;

class UserEventSubscriber extends BaseEventSubscriber
{

    public function prePersist(LifecycleEventArgs $args): void
    {
        parent::prePersist($args);
        $user = $args->getObject();
        if ($user instanceof UserInterface) {
            $this->handle_password($user);
            $this->handle_api_key($user);
            $this->handle_public_key($user);
        }
    }

    private function handle_password(UserInterface $user)
    {
        $plain = $user->getPassword();
        if ($plain) {
            $user->setPassword($this->pw->encodePassword($user, $plain));
        }
    }

    private function handle_api_key($user)
    {
        $plain = $user->getPassword();
        if ($plain) {
            if (method_exists($user, 'setApiKey')) {
                $user->setApiKey(\md5("@private:{$plain}"));
            }
        }
    }

    private function handle_public_key(UserInterface $user)
    {
        $username = $user->getUsername();
        if (method_exists($user, 'setPublicKey') &&
            method_exists($user, 'getEmail'))
        {
            $email = $user->getEmail();
            $user->setPublicKey(\md5("@public:$username:$email"));
        }
    }
}