<?php

declare(strict_types=1);

namespace App\HttpClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PokemonApi
{
    public function __construct(private HttpClientInterface $pokemonClient)
    {
    }

    /**
     * @return PokemonListDto[]
     */
    public function listAll(): array
    {
        /** @var ResponseInterface $response */
        $response = $this->pokemonClient->request('GET', '/api/v2/pokemon?limit=300');
        $responseData = $response->toArray();

        $pokemons = [];
        foreach ($responseData['results'] as $pokemonData) {
            $pokemons[] = new PokemonListDto($pokemonData['name']);
        }

        return $pokemons;
    }

    public function getPokemon(string $name): PokemonDto
    {
        $response = $this->pokemonClient->request('GET', "/api/v2/pokemon/$name")->toArray();

        $abilities = [];
        foreach ($response['abilities'] as $ability) {
            $abilities[] = $ability['ability']['name'];
        }

        return new PokemonDto(
            name: $response['name'],
            abilities: $abilities,
            baseExperience: $response['base_experience'],
        );
    }
}
