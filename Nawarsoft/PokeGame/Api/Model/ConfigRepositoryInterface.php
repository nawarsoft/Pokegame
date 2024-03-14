<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Api\Model;

interface ConfigRepositoryInterface
{
    public const POKEMON_NAME_ATTRIBUTE_CODE = 'pokemon_name';
    public const CONFIG_PATH_NAWARSOFT_POKEGAME_GENERAL_ENABLED = 'nawarsoft_pokegame/general/enabled';
    public const CONFIG_PATH_NAWARSOFT_POKEGAME_GENERAL_API_URL = 'nawarsoft_pokegame/general/api_url';

    /** @return bool */
    public function getIsEnabled(): bool;

    /** @return string */
    public function getApiUrl(): string;
}
