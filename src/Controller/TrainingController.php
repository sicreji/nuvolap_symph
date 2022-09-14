<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use \App\Entity\Training;
use \App\Entity\Student;

class TrainingController extends AbstractController
{
    /**
     * @Route("/training", name="app_training")
     */
    public function index(): Response
    {
        $training_repo = $this->getDoctrine()->getRepository(Training::class);
        $trainings = $training_repo->findAll();

        return $this->render('training/index.html.twig', [
            'trainings' => $trainings
        ]);
    }

    /**
     * @Route("/training_post", name="app_training_post")
     */
    public function post(): Response
    {
        $training = new Training();
        $training->setTitle("Angular");
        $training->setDuration(3);

        /*
        $student_id = 2;
        $student_repo = $this->getDoctrine()->getRepository(Student::class);
        $student = $student_repo->find($student_id);
        $training->addStudent($student);
        */

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($training);
        $manager->flush();

        return new Response($training->getId());
    }
}
