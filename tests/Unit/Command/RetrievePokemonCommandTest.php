<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command;

use App\Command\RetrievePokemonCommand;
use App\HttpClient\PokemonApi;
use App\HttpClient\PokemonListDto;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class RetrievePokemonCommandTest extends TestCase
{
    public function testExecuteSuccessfully(): void
    {
        $pokemonApiMock = $this->createConfiguredMock(PokemonApi::class, []);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $entityManagerMock->expects($this->exactly(2))->method('persist');
        $entityManagerMock->expects($this->once())->method('flush');

        $pokemonDtoExpected = [];
        $pokemonDtoExpected[] = new PokemonListDto('Pikachu');
        $pokemonDtoExpected[] = new PokemonListDto('Salameche');

        $pokemonApiMock->method('listAll')->willReturn($pokemonDtoExpected);

        $application = new Application();
        $application->add(new RetrievePokemonCommand($pokemonApiMock, $entityManagerMock));

        $command = $application->find('app:retrieve-pokemon');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('[INFO] Pokemon Pikachu added', $output);
        $this->assertStringContainsString('[INFO] Pokemon Salameche added', $output);
        $this->assertStringContainsString('Pokemons successully added', $output);
    }
}
