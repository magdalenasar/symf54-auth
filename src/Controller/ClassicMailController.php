<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassicMailController extends AbstractController
{
    /**
     * @Route("/mail")
     */
    public function mailNative(): Response
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <steven@inform.be>' . "\r\n";
        $headers .= 'To: Steven <steven@inform.be>' . "\r\n";
        $headers .= 'Bcc: info@inform.be' . "\r\n";

        $to = "steven@inform.be";
        $subject = "Native Mail Function Alive!";
        $message = "<body><h1>Hello from Native Mail!</h1></body>";

        mail($to, $subject, $message, $headers);

        return new Response("Native Mail verzonden!");
    }
}
