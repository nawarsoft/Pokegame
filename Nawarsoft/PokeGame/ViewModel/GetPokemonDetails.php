<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Nawarsoft\PokeGame\Api\Model\ConfigRepositoryInterface;
use Nawarsoft\PokeGame\Service\GetPokemonData;
use Nawarsoft\PokeGame\ValueObject\PokemonDetails;

class GetPokemonDetails implements ArgumentInterface
{
    /**
     * @param GetPokemonData $pokemonData
     */
    public function __construct(
        private readonly GetPokemonData $pokemonData
    ) {}

    /**
     * @param Product $product
     * @return PokemonDetails|null
     */
    public function getByProduct(Product $product): ?PokemonDetails
    {
        $pokemonNameAttribute = $product->getCustomAttribute(ConfigRepositoryInterface::POKEMON_NAME_ATTRIBUTE_CODE);

        if (!$pokemonNameAttribute instanceof AttributeInterface || $pokemonNameAttribute->getValue() === null) {
            return null;
        }

        $pokemonData = $this->pokemonData->getByPokemonName($pokemonNameAttribute->getValue());

        if (empty($pokemonData)) {
            return null;
        }

        return new PokemonDetails(
            $pokemonData['name'],
            $pokemonData['height'],
            $pokemonData['weight'],
            $pokemonData['abilities'],
            $pokemonData['types']
        );
    }
}
