<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Nawarsoft\PokeGame\ValueObject\PokemonDetails as PokemonDetailsObject;
use Nawarsoft\PokeGame\ViewModel\GetPokemonDetails;

class PokemonDetails extends Template
{
    /**
     * @param GetPokemonDetails $pokemonDetails
     * @param Registry $registry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        private readonly GetPokemonDetails $pokemonDetails,
        private readonly Registry $registry,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return PokemonDetailsObject|null
     */
    public function getPokemonDetails(): ?PokemonDetailsObject
    {
        return $this->pokemonDetails->getByProduct($this->getProduct());
    }

    /**
     * @return Product
     */
    private function getProduct(): Product
    {
        return $this->registry->registry('current_product');
    }
}
