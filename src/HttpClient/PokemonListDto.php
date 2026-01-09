<?php

declare(strict_types=1);

namespace App\HttpClient;

final class PokemonListDto
{

    public function __construct(private string $label)
    {
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}
