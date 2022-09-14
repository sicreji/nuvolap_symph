<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/exo4_form", name="exo4_form")
     */
    public function exo4(Request $req): Response
    {
        $this->render("exo/exo4_form.html.twig");
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


}
