<?php
namespace App\Services\Notifications;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class UserNotifierService {
    

    private MailerInterface $mailer;

    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notify(User $user)
    {
        $email = (new Email())
            ->from('noreply@site.fr')
            ->subject('Test Symfony Messenger')
            ->to($user->getEmail())
            ->html($this->twig->render('email/notification.html.twig', ['user' => $user]));
        sleep(2);
        throw new \Exception("Error");
        $this->mailer->send($email);
    }
}