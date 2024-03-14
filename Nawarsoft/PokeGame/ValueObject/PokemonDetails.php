<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\ValueObject;

class PokemonDetails
{
    /**
     * @param string $name
     * @param int $height
     * @param int $weight
     * @param array $abilities
     * @param array $types
     */
    public function __construct(
        private readonly string $name,
        private readonly int $height,
        private readonly int $weight,
        private readonly array $abilities,
        private readonly array $types
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return array
     */
    public function getAbilities(): array
    {
        return $this->abilities;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
