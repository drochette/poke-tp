<?php

declare(strict_types=1);

namespace App\HttpClient;

final class PokemonDto
{

    public function __construct(private string $name, private array $abilities, private int $baseExperience)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAbilities(): array
    {
        return $this->abilities;
    }

    public function getBaseExperience(): int
    {
        return $this->baseExperience;
    }

}
