<?php

declare(strict_types=1);

namespace App\Tests\Unit\HttpClient;

use App\HttpClient\PokemonApi;
use App\HttpClient\PokemonDto;
use App\HttpClient\PokemonListDto;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PokemonApiTest extends TestCase
{
    public function testListAllPokemons(): void
    {
        $clientHttpMock = $this->createMock(HttpClientInterface::class);
        $responseInterfaceMock = $this->createMock(ResponseInterface::class);

        $expectedJsonResponse = <<<JSON
{
  "count": 2,
  "next": "https://pokeapi.co/api/v2/pokemon?offset=20&limit=20",
  "previous": null,
  "results": [
    {
      "name": "Pikachu",
      "url": "https://pokeapi.co/api/v2/pokemon/1/"
    },
    {
      "name": "Salameche",
      "url": "https://pokeapi.co/api/v2/pokemon/2/"
    }
  ]
}
JSON;

        $responseInterfaceMock->expects($this->once())->method('toArray')->willReturn(json_decode($expectedJsonResponse, true));

        $clientHttpMock->expects($this->once())
            ->method('request')
            ->with('GET', '/api/v2/pokemon?limit=300')
            ->willReturn($responseInterfaceMock);

        $pokemonApi = new PokemonApi($clientHttpMock);

        $pokemonDtoExpected = [];
        $pokemonDtoExpected[] = new PokemonListDto('Pikachu');
        $pokemonDtoExpected[] = new PokemonListDto('Salameche');

        $this->assertEquals($pokemonDtoExpected, $pokemonApi->listAll());
    }

    public function testGetAPokemon(): void
    {
        $clientHttpMock = $this->createMock(HttpClientInterface::class);
        $responseInterfaceMock = $this->createMock(ResponseInterface::class);

        $expectedJsonResponse = <<<JSON
{
  "name": "Pikachu",
  "abilities": [
    {
      "ability": {
        "name": "static",
        "url": "https://pokeapi.co/api/v2/ability/9/"
      },
      "is_hidden": false,
      "slot": 1
    },
    {
      "ability": {
        "name": "lightning-rod",
        "url": "https://pokeapi.co/api/v2/ability/31/"
      },
      "is_hidden": true,
      "slot": 3
    }
  ],
  "base_experience": 112
}
JSON;

        $responseInterfaceMock->expects($this->once())->method('toArray')->willReturn(json_decode($expectedJsonResponse, true));

        $clientHttpMock->expects($this->once())
            ->method('request')
            ->with('GET', '/api/v2/pokemon/pikachu')
            ->willReturn($responseInterfaceMock);

        $expectedPokemonDto = new PokemonDto('Pikachu', ['static', 'lightning-rod'], 112);

        $pokemonApi = new PokemonApi($clientHttpMock);

        $this->assertEquals($expectedPokemonDto, $pokemonApi->getPokemon('pikachu'));
    }
}
