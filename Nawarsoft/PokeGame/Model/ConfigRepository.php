<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Nawarsoft\PokeGame\Api\Model\ConfigRepositoryInterface;

class ConfigRepository implements ConfigRepositoryInterface
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {}

    /**
     * @return bool
     */
    public function getIsEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_PATH_NAWARSOFT_POKEGAME_GENERAL_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return (string)$this->scopeConfig->getValue(self::CONFIG_PATH_NAWARSOFT_POKEGAME_GENERAL_API_URL);
    }
}
