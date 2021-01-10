<?php
namespace App\Subscriber;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

class FailedMessageSubscribe implements EventSubscriberInterface
{   
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            WorkerMessageFailedEvent::class => 'onMessageFailed'
        ];
    }

    public function onMessageFailed(WorkerMessageFailedEvent $event)
    {
        $message = get_class($event->getEnvelope()->getMessage());
        $trace = $event->getThrowable()->getTraceAsString();
        $email = (new Email())
            ->from('noreply@site.fr')
            ->subject('Messenger Error notification')
            ->to('admin@site.fr')
            ->text(<<<TEXT
            Une erreur est survenue lors du traitement de : {$message}
            
            Trace des erreurs: 
            {$trace}
TEXT);
        $this->mailer->send($email);
    }
}