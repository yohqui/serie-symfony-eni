<?php

namespace App\Notification;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer =$mailer;
    }

    public function sendNewUserNotificationToAdmin(UserInterface $user) : void
    {
        // pour tester le service
        //file_put_contents('debug.txt', $user->getEmail());

        $message = new Email();
        $message
            ->from('account@series.com')
            ->to('admin@series.com')
            ->subject('new account create on series.com !')
            ->html('<h1>New account !</h1>email : '.$user->getEmail());

        $this->mailer->send($message);
    }


}