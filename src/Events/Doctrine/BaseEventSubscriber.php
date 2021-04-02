<?php


namespace App\Events\Doctrine;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

abstract class BaseEventSubscriber implements EventSubscriber, LoggerAwareInterface
{

    protected UserPasswordEncoderInterface $pw;
    protected RequestStack $req;
    protected ParameterBagInterface $params;
    protected LoggerInterface $logger;
    protected MailerInterface $mailer;
    protected EntityManagerInterface $em;


    public function __construct(
        UserPasswordEncoderInterface $pw,
        ParameterBagInterface $params,
        RequestStack $req,
        MailerInterface $mailer,
        EntityManagerInterface $em
    )
    {
        $this->pw = $pw;
        $this->req = $req;
        $this->params = $params;
        $this->mailer = $mailer;
        $this->em = $em;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::postPersist,
            Events::postRemove,
            Events::preUpdate,
            Events::postUpdate
        ];
    }
    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entity->setCreatedAt(new \DateTime());
        $entity->setModifiedAt(new \DateTime());
        if (method_exists($entity, 'setStatus')) {
            $entity->setStatus('active');
        }
        if (method_exists($entity, 'setNote')) {
            $entity->setStatus('');
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entity->setModifiedAt(new \DateTime());
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
    }
}