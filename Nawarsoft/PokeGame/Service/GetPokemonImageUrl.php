<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Service;

use Magento\Catalog\Model\Product;
use Magento\Framework\Api\AttributeInterface;
use Nawarsoft\PokeGame\Api\Model\ConfigRepositoryInterface;

class GetPokemonImageUrl
{
    /**
     * @param GetPokemonData $pokemonData
     */
    public function __construct(
        private readonly GetPokemonData $pokemonData
    ) {}

    /**
     * @param Product $product
     * @return string
     */
    public function getByProduct(Product $product): string
    {
        $pokemonNameAttribute = $product->getCustomAttribute(ConfigRepositoryInterface::POKEMON_NAME_ATTRIBUTE_CODE);

        if (!$pokemonNameAttribute instanceof AttributeInterface || $pokemonNameAttribute->getValue() === null) {
            return '';
        }

        $pokemonData = $this->pokemonData->getByPokemonName($pokemonNameAttribute->getValue());

        return $pokemonData['sprites'] ?? $pokemonData['sprites']['front_default'] ??
            $pokemonData['sprites']['front_default'] ? $pokemonData['sprites']['front_default'] : '';
    }
}
