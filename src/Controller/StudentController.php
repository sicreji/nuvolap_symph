<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use \App\Entity\Student;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="app_student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/student_form", name="app_student_form")
     */
    public function form(): Response
    {
        return $this->render('student/form.html.twig');
    }

    /**
     * @Route("/student_post", name="app_student_post")
     */
    public function post(Request $req): Response
    {
        $student = new Student();
        $student->setFirstname($req->request->get("firstname"));
        $student->setLastname($req->request->get("lastname"));
        $student->setEmail($req->request->get("email"));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($student);
        $manager->flush();

        return $this->render('student/form.html.twig');
    }
}
