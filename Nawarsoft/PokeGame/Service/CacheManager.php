<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Service;

use Magento\Framework\App\CacheInterface;

class CacheManager
{
    private const CACHE_ID = 'POKE_GAME_POKEMON_DATA';

    /**
     * @param CacheInterface $cache
     */
    public function __construct(
        private readonly CacheInterface $cache
    ) {}

    /**
     * @param string $pokemonName
     * @return string
     */
    public function load(string $pokemonName): string
    {
        return (string)$this->cache->load($this->getCacheId($pokemonName));
    }

    /**
     * @param string $pokemonName
     * @param string $data
     * @return void
     */
    public function save(string $pokemonName, string $data): void
    {
        $this->cache->save(
            $data,
            $this->getCacheId($pokemonName),
            [self::CACHE_ID],
            60 * 60 * 12
        );
    }

    /**
     * @param string $pokemonName
     * @return void
     */
    public function clear(string $pokemonName): void
    {
        $this->cache->remove($this->getCacheId($pokemonName));
    }

    /**
     * @param string $pokemonName
     * @return string
     */
    private function getCacheId(string $pokemonName): string
    {
        return self::CACHE_ID . md5($pokemonName);
    }
}
