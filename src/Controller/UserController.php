<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PokedexRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{

    public function __construct(private PokedexRepository $pokedexRepository)
    {
    }

    #[Route('/my_pokedex', name: 'app_my_pokedex')]
    public function index(): Response
    {
        $pokedexData = $this->pokedexRepository->findBy(['user' => $this->getUser()]);

        return $this->render('user/my_pokedex.html.twig',
        [
            'pokedexData' => $pokedexData
        ]
        );
    }
}
