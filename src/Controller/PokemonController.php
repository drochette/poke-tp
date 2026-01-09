<?php

namespace App\Controller;

use App\Entity\Pokedex;
use App\Entity\Pokemon;
use App\HttpClient\PokemonApi;
use App\Repository\PokedexRepository;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class PokemonController extends AbstractController
{
    public function __construct(
        private PokemonRepository $pokemonRepository,
        private PokemonApi $pokemonApi,
        private PokedexRepository $pokedexRepository,
    ) {
    }

    #[Route('/', name: 'app_home')]
    #[Route('/pokemons', name: 'app_list_pokemons')]
    public function index(
        #[MapQueryString] PaginationDto $paginationDto,
    ): Response {
        $pokemons = $this->pokemonRepository->findAllPaginated(
            $paginationDto->page,
            $paginationDto->limit,
        );

        return $this->render('pokemon/list.html.twig', [
            'pokemons' => $pokemons->getIterator(),
        ]);
    }

    #[Route('/pokemons/{id}', name: 'app_view_a_pokemon')]
    public function view(Pokemon $pokemon): Response
    {
        $pokemonData = $this->pokemonApi->getPokemon($pokemon->getLabel());

        return $this->render('pokemon/view.html.twig', [
            'pokemon' => $pokemon,
            'pokemonInfo' => $pokemonData,
        ]);
    }

    #[Route('/pokemons/{id}/add_to_pokedex', name: 'app_add_pokemon_to_pokedex')]
    public function addToPokedex(Pokemon $pokemon): Response
    {
        $userPokemons = $this->pokedexRepository->findBy(['user' => $this->getUser()]);
        $isPokemonAlreadyInPokedex = null !== $this->pokedexRepository->findOneBy(['user' => $this->getUser(), 'pokemon' => $pokemon]);

        if ($isPokemonAlreadyInPokedex) {
            $this->addFlash('error', 'Désolé le pokemon est déjà dans votre pokedex');

            return $this->redirectToRoute('app_view_a_pokemon', ['id' => $pokemon->getId()]);
        }

        if (count($userPokemons) >= 20) {
            $this->addFlash('error', 'Désolé vous avez atteint le nombre maximum de pokemons dans votre pokedex (20)');

            return $this->redirectToRoute('app_view_a_pokemon', ['id' => $pokemon->getId()]);
        }

        $pokedex = new Pokedex();
        $pokedex->setUser($this->getUser());
        $pokedex->setPokemon($pokemon);

        $this->pokedexRepository->save($pokedex);

        $this->addFlash('success', 'Le pokemon a été ajouté à votre pokedex');

        return $this->redirectToRoute('app_view_a_pokemon', ['id' => $pokemon->getId()]);
    }
}
