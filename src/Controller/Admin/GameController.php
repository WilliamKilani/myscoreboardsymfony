<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    

    #[Route('/admin/game', name: 'app_admin_game')]
    public function index(GameRepository $gameRepository): Response
    {
        // On ne PEUT PAS instancier d'Objets d'une classe Repository
        // On doit les passer dans les arguments d'une méthode d'un controleur
        // NB : pour chaque classe créée, il y a une classe Repository qui correspond et qui permet de faire des requêtes SELECT sur la table correspondante
    // $gameRepository = new GameRepository;

        return $this->render('admin/game/index.html.twig', [
            "games" => $gameRepository->findAll()
        ]);
    }

    // La classe Request permet d'instancier un objet qui contient toutes les valeurs des variables super-globales de PHP.
    // Ces valeur sont dans des propriétés.
    // $request->query      contient        $_GET
    // $request->request    contient        $_POST
    // $request->server    contient        $_SERVER et ainsi de suite pour les autres super-globales
    // Pour accéder aux valeurs, on utilisera sur ces propriétés la méthode ->get('indice de la valeur que l'on va récupérer')

    #[Route('/admin/game/new', name: 'app_admin_game_new')]

    /* La classe EntityMangager va permettre d'exécuter les requêtes qui modifient les données (INSERT, UPDATE, DELETE).
     * L'EntityManager va toujours utiliser des objets Entity pour modifier les données.
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        // dump($request);
        // dd($request);

        $jeu = new Game;

        // On crée un objet $form pour gérer le formulaire. Il est créé à partir de la classe GameType. On relie ce formulaire à l'objet $jeu
        $form = $this->createForm(GameType::class, $jeu);

        // L'objet $form va gérer ce qui vient de la requête HTTP (avec l'objet $request)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // la méthode persist() prépare la requête INSERT avec les données de l'objet passé en argument
            $em->persist($jeu);

            // la méthode flush() exécute les requêtes en attente et donc modifie la base de donnée
            $em->flush($jeu);

            // redirection vers une route du projet
            return $this->redirectToRoute('app_admin_game');
        }

        return $this->render('/admin/game/form.html.twig', [
            "formGame" => $form->createView(),
        ]);
    }

    #[Route('/admin/game/edit/{id}', name: 'app_admin_game_edit')]
    public function edit($id, GameRepository $gameRepository, EntityManagerInterface $em, Request $rq)
    {
        // dd($id);
        $jeu = $gameRepository->find($id);
        $form = $this->createForm(GameType::class, $jeu);
        $form->handleRequest($rq);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('app_admin_game');
        }

        return $this->render('/admin/game/form.html.twig', [
            "formGame" => $form->createView(),
        ]);
    }

    // Autre façon de faire l'edit :
    #[Route('/admin/game/modifier/{title}', name: 'app_admin_game_modifier')]
    // Si le chemin de la route contient une partie variable (donc entree {}), on peut récupérer un objet entité directement avec la valeur de cette partie de l'URL. Il faur que le nom de ce parametre soit le nom d'une propriété de la classe Entity.
    // Par exemple, le parametre est {title}, parce que dans l'entité Game il y a une propriété title.
    // Dnas les arguments de la méthode, on peut alors utiliser un objet de la classe Game ($jeu dans l'exemple)
    public function modifier(Game $jeu , EntityManagerInterface $em, Request $rq)
    {
        // dd($id);
        // $jeu = $gameRepository->find($id);
        $form = $this->createForm(GameType::class, $jeu);
        $form->handleRequest($rq);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('app_admin_game');
        }

        return $this->render('/admin/game/form.html.twig', [
            "formGame" => $form->createView(),
        ]);
    }

    #[Route('/admin/game/delete/{id}', name: 'app_admin_game_delete')]
    public function delete($id, GameRepository $gameRepository, Request $rq, EntityManagerInterface $em)
    {
        $jeu = $gameRepository->find($id);
        if( $rq->isMethod("POST")){
            $em->remove($jeu);
            $em->flush();
            return $this->redirectToRoute('app_admin_game');
        }

        return $this->render('/admin/game/delete.html.twig', [
            "game" => $jeu,
        ]);
    }

    // #[Route('/admin/game', name: 'app_admin_game')]
    // #[Route('/admin/show/{id}', name: 'show')]
    // public function index(GameRepository $gameRepository, PlayerRepository $playerRepository, $id=null): Response
    // {

    //     // Une table de bdd est correspondante à une entité dans l'app
    //     // lorsque l'on souhaite récuperer des données d'une table en bdd (requete de SELECT), il nous faut appeler le repository de l'entité (table) sur laquelle la requte a lieu

    //     if($id):
    //         $player=$playerRepository->find($id);
    //     else: 
    //         $player=false;
    //     endif;

    //     $players=$playerRepository->findAll();

    //     // dump($players);
    //     // dd($players);

    //     // On ne PEUT PAS instancier d'Objets d'une classe Repository
    //     // On doit les passer dans les arguments d'une méthode d'un controleur
    //     // NB : pour chaque classe créée, il y a une classe Repository qui correspond et qui permet de faire des requêtes SELECT sur la table correspondante

    //     // $gameRepository = new GameRepository;
    //     return $this->render('admin/game/index.html.twig', [
    //         "games" => $gameRepository->findAll(),
    //         'players' => $players,
    //         'player' => $player
    //     ]);

        
    // }






}

