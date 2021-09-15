<?php

namespace App\Services;

use Twig\Environment;
use App\Entity\Contact;
// use Spipu\Html2Pdf\Tag\Html\Address;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\ContactMessage;
use App\Entity\QuotationRequest;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;


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
    public function contactMessageNotification(Contact $contactMessage)
    {
        $email = (new NotificationEmail())
            ->from(new Address(
                $this->parameterBag->get('app.from_email'),
                $this->parameterBag->get('app.name')
            ))
            ->to($this->parameterBag->get('app.to_email'))
            ->bcc($this->parameterBag->get('app.to_email2'))
            ->subject('🔔Notification - Message')
            ->htmlTemplate('back/email/contact_message.html.twig')
            ->context([
                'contact_message' => $contactMessage,
                'website_name' => $this->parameterBag->get('app.name'),
                'footer_text' => $this->parameterBag->get('app.name'),
                'footer_url' => $this->router->generate(
                    'front_home',
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ])
            ->action("Cliquer ici pour l'ouvrir dans l'application", $this->router->generate(
                'back_contact_message_read',
                ['id' => $contactMessage->getId(), ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ))
            ->importance(NotificationEmail::IMPORTANCE_MEDIUM)
            ->replyTo($contactMessage->getEmail());
        $this->mailer->send($email);
    }

    public function createBodyMail($view, array $parameters)
    {
        return $this->engine->render($view, $parameters);
    }
}