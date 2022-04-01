<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')] //nom de l'URL
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            // render('test/index.html.twig') représente le fichier dans lequel on met nos variables
            'controller_name' => 'TestController',
            'texte' => 'le texte que je veux afficher',
            
        ]);
    }

    #[Route('/test/calcul', name: 'calcul')]
    public function calcul(): Response
    {
        $a = 12;
        $b = 7;

        return $this->render('test/index.html.twig', [
            'controller_name' => 'William',
            'texte' => '',
            'calcul' => $a + $b,
        ]);
    }

    #[Route('/test/salut', name: 'salut')]
    public function salut()
    {
        return $this->render('test/salut.html.twig', [
            'prenom' => 'mon pote',
            
        ]);
    }

    #[Route('/test/tableau')]
    public function tableau()
    {
        $tableau = [ 'bonjour', "je m'appelle", 789, true, 12, 38 ];
        return $this->render('test/tableau.html.twig', ['tableau' => $tableau
    ]);
    }

    #[Route('/test/tableau-assoc')]
    public function tab()
    {
        $p = [
            "nom" => "Cérien",
            "prenom" => "Jean",
            "age" => 32
        ];
        return $this->render("test/assoc.html.twig", ["personne" => $p ]);
    }
    
    #[Route('/test/objet')]
    public function objet()
    {
        $objet = new \stdClass; // stdClass sert à utiliser une classe sans en créer une
        $objet->prenom = "Nordine";
        $objet->nom = "Ateur";
        $objet->age = 40;
        return $this->render("test/assoc.html.twig", ["personne" => $objet ]);
    }

    
    
}
