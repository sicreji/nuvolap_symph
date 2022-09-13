<?php

namespace App\Controller;

use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Routing\Annotation\Route;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemoController extends AbstractController
{
    private $students = [
        ["name" => "Julie", "job" => "admin"],
        ["name" => "Jean-Luc", "job" => "dev"],
        ["name" => "Arnaud", "job" => "dev"]
    ];

    public function demo1(): Response
    {
        //$response = new \Symfony\Component\HttpFoundation\Response();
        $response = new Response();
        $title = "demo1";
        $content = $title . " via la méthode setContent";
        $response->setContent($content);
        
        // retourne une réponse HTTP
        return $response;
    }

    /**
     * @Route("/demo2", name="demo2")
     */
    public function demo2(): Response
    {
        $res = new Response();
        $content = "<h1>Demo2</h1>";
        $content .= "<p>Simple paragraphe</p>";
        $res->setContent($content);
        return $res;
    }

    /**
     * @Route("/demo3", name="demo3")
     */
    public function demo3(Request $req): Response
    {
        $res = new Response();
        $student = $req->query->get("student");
        $job = $req->query->get("job");
        //dd($req); // dump & die

        $res->setContent("L'étudiant: " . $student . " exerce le métier de " . $job);
        return $res;
    }

    /**
     * @Route("/demo4", name="demo4")
     */
    public function demo4(Request $req): Response
    {
        // tester avec curl:
        // curl localhost:8001/demo4 -H "X-Token: abc123"
        $res = new Response();
        $validToken = "abc123";
        //dd($req);
        $userAgent = $req->headers->get("User-Agent");
        $token = $req->headers->get("X-Token");

        if (!$token) {
            $res->setContent("Accès refusé, token non fourni");
        } else {
            if ($token == $validToken) {
                $res->setContent("Accès autorisé");
            } else {
                $res->setContent("Accès refusé, token non valide");
            }
        }

        // ajout d'entête personnalisés à la réponse HTTP
        $res->headers->set("X-Token", md5("coucou"));
        $res->headers->set("X-Powered-By", "Ruby/6.3.1");
        return $res;
    }

    /**
     * @Route("/demo5", name="demo5")
     */
    public function demo5(Request $req): Response
    {
        $method = $req->getMethod();

        if ($method == Request::METHOD_GET) {
            return new Response("Méthode HTTP autorisée");
        } else {
            return new Response("Méthode HTTP non autorisée");
        }
    }

    /**
     * @Route("/demo6", name="demo6")
     */
    public function demo6(): Response
    {
        // datasource
        // $students = [
        //     ["name" => "Julie", "job" => "admin"],
        //     ["name" => "Jean-Luc", "job" => "dev"],
        //     ["name" => "Arnaud", "job" => "dev"]
        // ];

        //return new Response(json_encode($students));
        //return new JsonResponse($students);
        //return $this->json($students);
        return $this->json($this->students);
    }

    /**
     * @Route("/demo_tmp", name="demo_tmp")
     */
    public function demo_tmp(Request $req): Response
    {
        // récupère la valeur associée à un paramètre posté
        dd($req->request->get("user"));
        return new Response("ok");
    }

    /**
     * @Route("/demo7", name="demo7")
     */
    public function demo7(): Response
    {
        $res = new Response();
        $res->headers->set("Content-Type", "application/json");
        $res->headers->set("X-Token", md5("La terre est ronde"));
        $res->setStatusCode(Response::HTTP_NOT_FOUND); // 404
        $res->setContent("Ressource trouvée, bravo !");
        return $res;
    }

    /**
     * @Route("/demo8/{student}", name="demo8")
     */
    public function demo8($student): Response
    {
        if (strlen($student) > 10) {
            return new Response("Nom trop long !");
        }
        return new Response($student);
    }

    /**
     * @Route("/demo9/{num}", 
     *  name="demo9",
     *  requirements={"num"="\d+"},
     *  methods={"POST", "DELETE"}
     * )
     */
    public function demo9($num): Response
    {
        return new Response($num * $num);
    }

    /**
     * @Route("/demo10", name="demo10")
     */
    public function demo10(): Response
    {
        return $this->render("demo/demo10.html.twig");
    }

    /**
     * @Route("/demo11", name="demo11")
     */
    public function demo11(): Response
    {
        return $this->render("demo/demo11.html.twig", [
            "title" => "Démo 11",
            "students" => $this->students
        ]);
    }

    /**
     * @Route("/demo12", name="demo12")
     */
    public function demo12(): Response
    {
        return $this->render("demo/demo12.html.twig", [
            "title" => "Démo 12",
            "students" => $this->students
        ]);
    }




}