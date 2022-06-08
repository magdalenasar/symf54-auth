<?php

namespace App\Controller;

use App\Services\DBManager;
use App\Services\Logger;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $dbManager;
    private $logger;

    public function __construct(DBManager $dbManager, Logger $logger)
    {
        $this->dbManager = $dbManager;
        $this->logger = $logger;
    }

    /**
     * @Route("/home", name="app_home")
     * @return Response
     */
    public function app_home()
    {
        $this->logger->Log("Dit is een bericht vanuit de HomeController!");
        return $this->render("home/home.html.twig");
    }

    /**
     * @Route("/api/films", methods={"GET"}, name="api_films_get")
     * @return Response
     */
    public function apiFilms()
    {
        $data = $this->dbManager->GetData("select * from film");
        return $this->json($data);
    }

    /**
     * @Route("/api/films", methods={"POST"}, name="api_films_post")
     * @return Response
     */
    public function apiFilmsPost()
    {
        //https://lornajane.net/posts/2008/accessing-incoming-put-data-from-php
        $contents = json_decode( file_get_contents("php://input") );

        if ( $contents )    // als de body in JSON formaat is...
        {
            $title = $contents->title;
        }
        else // als we een klassiek HTML form verzenden...
        {
            $title = $_POST['title'];
        }

        $messages[] = "Posting a new film! " . $title;

        return $this->json($messages);
    }

    /**
     * @Route("/api/film/{id}", methods={"GET"}, name="api_film")
     * @return Response
     */
    public function apiGetOneFilm($id)
    {
        $data = $this->dbManager->GetData("select * from film where film_id=$id");
        return $this->json($data);
    }

    /**
     * @Route("/form", methods={"GET"}, name="form_register")
     */
    public function formRegister()
    {
        return $this->render("forms/register.html.twig");
    }

    /**
     * @Route("/myapi/appel", methods={"GET"}, name="appel_route")
     */
    public function appel()
    {
        return new Response("Dit is een appel, alleen voor de ADMIN");
    }
}