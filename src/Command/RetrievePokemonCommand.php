<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\HttpClient\PokemonApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:retrieve-pokemon',
    description: 'Add a short description for your command',
)]
class RetrievePokemonCommand extends Command
{
    public function __construct(private PokemonApi $pokemonApi, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $pokemons = $this->pokemonApi->listAll();
        foreach($pokemons as $pokemon) {
            $pokemonEntity  = new Pokemon();
            $pokemonEntity->setLabel($pokemon->getLabel());
            $this->entityManager->persist($pokemonEntity);

            $io->info("Pokemon {$pokemon->getLabel()} added");
        }
        $this->entityManager->flush();

        $io->success("Pokemons successully added");


        return Command::SUCCESS;
    }
}
