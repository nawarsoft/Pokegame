<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Test\Unit\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Nawarsoft\PokeGame\Model\ConfigRepository;
use PHPUnit\Framework\TestCase;

class ConfigRepositoryTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configRepository = new ConfigRepository($this->scopeConfigMock);
    }

    /**
     * @return void
     */
    public function testGetIsEnabled(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with('nawarsoft_pokegame/general/enabled');

        $this->configRepository->getIsEnabled();
    }

    /**
     * @return void
     */
    public function testGetApiUrl(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with('nawarsoft_pokegame/general/api_url');

        $this->configRepository->getApiUrl();
    }
}
