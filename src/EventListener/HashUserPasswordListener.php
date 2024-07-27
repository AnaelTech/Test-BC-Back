<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(Events::prePersist)]
class HashUserPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof User) {
            return;
        }

        if (!preg_match('/^\$2y\$/', $entity->getPassword())) {
            $entity->setPassword($this->hasher->hashPassword($entity, $entity->getPassword()));
        }
    }
}
