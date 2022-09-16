<?php

namespace App\Controller;

use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Routing\Annotation\Route;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \Symfony\Component\Form\Extension\Core\Type\HiddenType;
use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\Session;

use \App\Custom\Proverb as CustomProverb;
use \App\Entity\Proverb;
use \App\Form\ProverbType;
use \App\Service\CalculatorService;
use \App\Event\TestEvent;

class DemoController extends AbstractController
{
    private $students = [
        ["name" => "Julie", "job" => "admin"],
        ["name" => "Jean-Luc", "job" => "dev"],
        ["name" => "Arnaud", "job" => "dev"]
    ];

    private $calc;

    public function __construct(CalculatorService $calculator)
    {
        $this->calc = $calculator;
    }

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

    /**
     * @Route("/demo13/{id}", name="demo13")
     */
    public function demo13($id): Response
    {

        if ($id > count($this->students)) {
            return new Response("Requête non valide...");
        }

        return $this->render("demo/demo13.html.twig", [
            "title" => "Démo 13",
            "student" => $this->students[$id - 1]
        ]);
    }

    /**
     * @Route("/demo14", name="demo14")
     */
    public function demo14(): Response
    {
        $p1 = new CustomProverb("Pierre qui roule n'amasse pas mousse", "fr");
        $p2 = new CustomProverb("Tra il dire e il fare c'è di mezzo il mare", "it");
        $p3 = new CustomProverb("Ad astra per aspera", "la");

        return $this->render("demo/demo14.html.twig", [
            "title" => "Démo 14",
            "proverbs" => [$p1, $p2, $p3],
            "len" => 12
        ]);
    }

    /**
     * @Route("/demo15", name="demo15", methods={"GET"})
     */
    public function demo15(): Response
    {
        return $this->render("demo/demo15.html.twig");
    }

    /**
     * @Route("/demo15", name="demo15_post", methods={"POST"})
     */
    public function demo15_post(Request $req): Response
    {
        $p1 = new Proverb();

        $body = $req->request->get("body");
        $lang = $req->request->get("lang");
        
        $p1->setBody($body);

        if ($lang != "_") {
            $p1->setLang($lang);
        }
        
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($p1);
        $manager->flush(); // exécute les requêtes sql en attente

        //return new Response("Id du proverbe persisté: " . $p1->getId());
        return $this->redirectToRoute("demo16");
    }

    /**
     * @Route("/demo16", name="demo16")
     */
    public function demo16(): Response
    {
        $session = new Session();
        $session->start();
        $user = $session->get('user');

        $repo = $this->getDoctrine()->getRepository(Proverb::class);
        $proverbs = $repo->findAll();

        return $this->render("demo/demo16.html.twig", [
            "proverbs" => $proverbs,
            "title" => "Démo 16",
            "connected_user" => $user
        ]);
    }

    /**
     * @Route("/demo17/{proverb_id}/delete", name="demo17")
     */
    public function demo17($proverb_id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Proverb::class);
        $proverb = $repo->findOneById($proverb_id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($proverb);
        $manager->flush();

        return $this->redirectToRoute("demo16");
    }

    /**
     * @Route("/demo18", name="demo18")
     */
    public function demo18(Request $req): Response
    {
        $proverb = new Proverb();

        $choices = [
            'Choisir une langue' => '_',
            'français' => 'fr',
            'italien' => 'it',
            'latin' => 'la'
        ];

        /*
        $form = $this->createFormBuilder($proverb)
            ->add('body', TextType::class, ['label' => 'Texte'])
            ->add('lang', ChoiceType::class, ['choices' => $choices])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();
        */
        
        $form = $this->createForm(ProverbType::class, $proverb)
            ->add('secret', HiddenType::class, ['mapped' => false]);

        // relation entre le formulaire et la requête
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            //dd($form->getData());
            //dd($proverb);
            $em = $this->getDoctrine()->getManager();

            if ($proverb->getLang() == '_') {
                $proverb->setLang(null);
            }

            $em->persist($proverb);
            $em->flush();

            return $this->redirectToRoute("demo16");
        }
        

        return $this->render("demo/demo18.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/demo19", name="demo19")
     */
    public function demo19(): Response
    {
        $calculator = new CalculatorService();
        return new Response($calculator->square(4));
    }

    /**
     * @Route("/demo20/{num2}", name="demo20")
     */
    public function demo20(
        CalculatorService $calculator,
        Request $req,
        $num2): Response
    {
        return new Response($calculator->square($req->query->get('num')) * $num2);
    }

    /**
     * @Route("/demo21", name="demo21")
     */
    public function demo21(): Response
    {
        //return new Response($this->calc->square(6));
        return new Response($this->calc->tva(100));

        //$c = new CalculatorService(0.1);
        //return new Response($c->tva(100));
    }

    /**
     * @Route("/demo22", name="demo22")
     */
    public function demo22(Request $req): Response
    {
        $repo = $this->getDoctrine()->getRepository(Proverb::class);
        
        $lang = $req->query->get("lang");
        
        //$proverbs = $repo->findByLang('it');
        //$proverbs = $repo->findByLangDql($lang);
        $proverbs = $repo->findByLangRaw($lang);
        
        dd($proverbs);
    }

    /**
     * @Route("/demo23", name="demo23")
     */
    public function demo23(Request $req, EventDispatcherInterface $dispatcher): Response
    {
        $event = new TestEvent("coucou");
        $dispatcher->dispatch($event, TestEvent::NAME);

        return $this->render("demo/demo23.html.twig");
    }

    /**
     * @Route("/demo24", name="demo24")
     */
    public function demo24(Request $req): Response
    {

        $user = $req->getSession()->get('user');

        if (!$user) {
            $res = new Response();
            $res->setStatusCode(401);
            return $res;
        }

        return $this->render("demo/demo23.html.twig");
    }

    /**
     * @Route("/demo25", name="demo25")
     */
    public function demo25(Request $req): Response
    {
        // après vérif en base de données => utiliseur connu
        $session = new Session();
        $session->start();

        $session->set('user', 'Chris');

        return new Response("User connected"); // cookie injecté dans les entêtes de la réponse

    }
}