<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Nawarsoft\PokeGame\Api\Model\ConfigRepositoryInterface;
use Nawarsoft\PokeGame\Service\CacheManager;

class ClearApiCacheAfterPokemonAttributeChanged implements ObserverInterface
{
    /**
     * @param CacheManager $cacheManager
     */
    public function __construct(
        private readonly CacheManager $cacheManager
    ) {}

    /**
     * @param Observer $observer
     * @return void
     * @throws Exception
     */
    public function execute(Observer $observer): void
    {
        $product = $observer->getData('product');
        $currentPokemonName = $product->getOrigData(ConfigRepositoryInterface::POKEMON_NAME_ATTRIBUTE_CODE);
        $newPokemonName = $product->getData(ConfigRepositoryInterface::POKEMON_NAME_ATTRIBUTE_CODE);

        if ($currentPokemonName !== null && $currentPokemonName !== $newPokemonName) {
            $this->cacheManager->clear($currentPokemonName);
        }
    }
}
