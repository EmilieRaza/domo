<?php

namespace App\Services;

use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;

/**
 * Class Mailer
 */
class Mailer
{
    private $engine;
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $engine)
    {
        $this->engine = $engine;
        $this->mailer = $mailer;
    }

    public function sendMessage($name, $from, $to, $subject, $body, $bcc = null, $attachement = null)
    {
        $mail = (new \Swift_Message($subject))
            ->setFrom([$from => $name])
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setReplyTo($from)
            ->setContentType('text/html');

        if(!empty($bcc)){
            $mail->setBcc($bcc);
        }

        if(!empty($attachement)){
            $mail->attach(\Swift_Attachment::fromPath($attachement));
        }

        $this->mailer->send($mail);
    }

    public function createBodyMail($view, array $parameters)
    {
        return $this->engine->render($view, $parameters);
    }
}