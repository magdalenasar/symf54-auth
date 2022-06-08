<?php
namespace App\Controller;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mailer\MailerInterface;

class MailerController extends AbstractController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('sarandeva2@gmail.com')
            ->to('sarandeva2@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        return new Response("Testmail verzonden!");
    }

    /**
     * @Route("/tempmail")
     */
    public function templateEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from('sarandeva2@gmail.com')
            ->to(new Address('sarandeva2@gmail.com'))
            ->subject('Thanks for signing up!')

            // path of the Twig template to render
            ->htmlTemplate('email/signup.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'sarandeva2@gmail.com',
            ])
        ;

        $mailer->send($email);

        return new Response("Template Mail verzonden!");
    }


    /**
     * @Route("/informmail")
     */
    public function informEmail(MailerInterface $mailer): Response
    {
        $plain_font = "font-family: 'Segoe UI', sans-serif; font-size: 16px;";
        $SP = '<p style="' . $plain_font . ' font-weight: normal; margin: 0; margin-bottom: 15px;">';
        $EP = '</p>';

        $email = (new TemplatedEmail())
            ->from('sarandeva2@gmail.com')
            ->to(new Address('sarandeva2@gmail.com'))
            ->subject('Bedankt voor uw registratie')
            ->htmlTemplate('email/inform.html.twig') // path of the Twig template to render
            ->context([
                'MAIL_SUBJECT'
                => 'Bedankt voor uw registratie',
                'AANSPREKING'
                =>$SP . "Beste Steven" . $EP,
                'BLOCK_VOOR_ACTION'
                =>$SP . 'Bedankt voor uw registratie. Gelieve deze nog te bevestigen door op de knop hieronder te klikken.' . $EP,
                'ACTION_HYPERLINK'
                => "https://wdev2.be/test21/eindwerk/confirm/abcdefg123456788",
                'ACTION_BUTTON_TEKST'
                => "Bevestig uw registratie",
                'BLOCK_NA_ACTION'
                => $SP . 'Als u nog vragen hebt, aarzel niet om ons te contacteren. 
                                We zullen u met plezier verder helpen.<br><br>' . $EP,
                'SLOT_BEGROETING'
                => $SP . "Met vriendelijke groet,<br>Inform BV". $EP,
                'font_fam_size_plain_text'
                => $plain_font,
                'footer_font_size'
                => "font-size: 14px;",
            ])
            //->attach( ... bijlage ...)
        ;

        $mailer->send($email);

        return new Response("Bevestiging Registratie Inform verzonden!");
    }


}
