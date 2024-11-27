<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($from, $to, $objet, $template, $context): Response
    {
        try {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($objet)
            ->htmlTemplate("mailer/$template.html.twig")
            ->context($context);

        $this->mailer->send($email);

    }catch (\Exception $e) {
        return new Response('Failed to send mail: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}