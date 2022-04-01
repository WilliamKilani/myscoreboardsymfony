<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, GameRepository $gr): Response
    {
        $word=$request->query->get('search');
        $jeux = $gr->findBySearch($word);
        return $this->render('search/index.html.twig', [
            'jeux' => $jeux,
            'result' => $word
            

        ]);
    }
}
