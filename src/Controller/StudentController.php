<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $stu = new Student();
        $stu->setNaam("Van Gucht")
            ->setVoornaam("Steven")
            ->setGeslacht(1)
            ->setPunten(75);

        dump($stu);

        $em->persist($stu);       //send $stu to Doctrine
        $em->flush();               //execute (insert or other needed) queries

        return new Response('Nieuwe student ' .
            $stu->getNaam() . " " . $stu->getVoornaam() . " aangemaakt!");
    }


    /**
     * @Route("/student/{id}", name="app_student_show")
     */
    public function show(Student $student)
    {
        if ( !$student ){
            throw $this->createNotFoundException("Student not found");
        }
        return $this->render('student/detail.html.twig', [
            'student' => $student,
        ]);
    }


    /**
     * @Route("/studenten", name="app_studenten_show")
     */
    public function showAll(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Student::class);
        $studenten = $repo->findAll();

        if ( !$studenten ){
            throw $this->createNotFoundException("Studenten not found");
        }
        dd($studenten);

        return new Response("Alle studenten vind je bij de dumps");
    }

}