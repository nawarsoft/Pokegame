<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Service;

use Exception;
use Magento\Framework\HTTP\Client\Curl;
use Nawarsoft\PokeGame\Model\ConfigRepository;
use Psr\Log\LoggerInterface;

class GetPokemonData
{
    private const HEADER_CONTENT_TYPE = 'application/json';

    /**
     * @param ConfigRepository $configProvider
     * @param Curl $curl
     * @param CacheManager $cacheManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ConfigRepository $configProvider,
        private readonly Curl $curl,
        private readonly CacheManager $cacheManager,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @param string $pokemonName
     * @return array
     */
    public function getByPokemonName(string $pokemonName): array
    {
        try {
            $cachedData = $this->cacheManager->load($pokemonName);

            if ($cachedData) {
                return json_decode($cachedData, true, 512, JSON_THROW_ON_ERROR);
            }

            $this->curl->setHeaders([
                'Content-Type' => self::HEADER_CONTENT_TYPE,
            ]);

            $this->curl->get($this->getPokemonApiUrl($pokemonName));
            $result = $this->curl->getBody();

            $this->cacheManager->save($pokemonName, $result);

            return json_decode($result, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Can not load data for %s pokemon', $pokemonName),
                [
                    'context' => 'GetPokemonData',
                    'pokemon_name' => $pokemonName,
                    'message' => $e->getTraceAsString(),
                ]
            );
        }

        return [];
    }

    /**
     * @param string $pokemonName
     * @return string
     */
    private function getPokemonApiUrl(string $pokemonName): string
    {
        return sprintf('%s/%s', $this->configProvider->getApiUrl(), $pokemonName);
    }
}
