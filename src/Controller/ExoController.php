<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use \App\Entity\Food;
use \App\Form\MonthType;
use \App\Service\PasswordService;

class ExoController extends AbstractController
{
    /**
     * @Route("/exo", name="app_exo")
     */
    public function index(): Response
    {
        return $this->render('exo/index.html.twig', [
            'controller_name' => 'ExoController',
        ]);
    }

    /**
     * @Route("/exo1", name="exo1")
     */
    public function exo1(Request $req): Response
    {
        $num = $req->query->get("num");
        return new Response("Carré de " . $num . ": " . $num * $num);
        // // /exo1?num=7 => Carré de 7: 49
    }

    /**
     * @Route("/exo2", name="exo2")
     */
    public function exo2(Request $req): Response
    {
        $ua = $req->headers->get("User-Agent");
        if (str_contains($ua, "curl") || str_contains($ua, "Postman")) {
            return new Response("Je ne parle pas aux inconnus");
        }
        return new Response("Coucou");
    }

    /**
     * @Route("/exo3", name="exo3")
     */
    public function exo3(Request $req): Response
    {
        $method = $req->getMethod();

        if ($method == Request::METHOD_GET) {
            $content = '<form method="POST">';
            $content .= '<input type="text" name="message">';
            $content .= '<input type="submit">';
            $content .= '</form>';
        } elseif ($method == Request::METHOD_POST) {
            $message = $req->request->get("message");
            $content = md5($message);
        } else {
            $content = "Je ne sais pas quoi dire...";
        }

        return new Response($content);
    }

    /**
     * @Route("/exo4_form", name="exo4_form", methods={"GET", "HEAD"})
     */
    public function exo4_form(Request $req): Response
    {
        return $this->render("exo/exo4_form.html.twig");
    }

    /**
     * @Route("/exo4_process", name="exo4_process", methods={"GET"})
     */
    public function exo4_process(Request $req): Response
    {

        $num = $req->query->get("num");
        $error = !$num || !is_numeric($num);

        return $this->render("exo/exo4_process.html.twig", [
            "num" => $num,
            "error" => $error,
        ]);
    }

    /**
     * @Route("/exo5_form", name="exo5_form")
     */
    public function exo5_form(Request $req): Response
    {
        return $this->render("exo/exo5_form.html.twig");
    }

    /**
     * @Route("/exo5_process", name="exo5_process")
     */
    public function exo5_process(Request $req): Response
    {
        $message = $req->query->get("message");
        return new Response(md5($message));
    }

    /**
     * @Route("/exo5_process2", name="exo5_process2")
     */
    public function exo5_process2(Request $req): Response
    {
        //var_dump($req->isXmlHttpRequest()); // bool(false): pourquoi ?
        $body = $req->getContent();
        $message= json_decode($body)->message;

        if (!$message || strlen($message) < 4) {
            return $this->json(array("hash" => "nada"));
        }
        
        return $this->json(array("hash" => md5($message)));
    }

    /**
     * @Route("/exo6_form", name="exo6_form")
     */
    public function exo6_form(Request $req): Response
    {
        if ($req->getMethod() == Request::METHOD_POST) {
            $food = new Food();
            $food->setName($req->request->get("name"));
            $food->setFat($req->request->get("fat"));
            $food->setCarbs($req->request->get("carbs"));
            $food->setProtein($req->request->get("protein"));
            $food->setProtein($req->request->get("protein"));
            $food->setCalory($req->request->get("calory"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($food);
            $em->flush();

            return new Response("Food id" . $food->getId() . " saved");
        }
        return $this->render("exo/exo6.html.twig", [
            "list" => false,
        ]);
    }

    /**
     * @Route("/exo6_list", name="exo6_list")
     */
    public function exo6_list(Request $req): Response
    {
        $repo = $this->getDoctrine()->getRepository(Food::class);
        $foods = $repo->findBy([], ['name' => 'ASC']);
        return $this->render("exo/exo6.html.twig", [
            "list" => true,
            "foods" => $foods,
        ]);
    }
    
    /**
     * @Route("/exo7", name="exo7")
     */
    public function exo7(): Response
    {
        $form = $this
            ->createForm(MonthType::class)
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
            ;

        return $this->render("exo/exo7.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/exo8", name="exo8")
     */
    public function exo8(PasswordService $password): Response
    {
        return new Response($password->generate());
    }

    /**
     * @Route("/exo9", name="exo9")
     */
    public function exo9(): Response
    {
        return $this->render("exo/exo9.html.twig");
    }

    /**
     * @Route("/exo10", name="exo10")
     */
    public function exo10(): Response
    {
        return $this->redirectToRoute("demo18");
    }



}
