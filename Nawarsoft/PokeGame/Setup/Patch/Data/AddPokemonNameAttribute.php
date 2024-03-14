<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Nawarsoft\PokeGame\Api\Model\ConfigRepositoryInterface;
use Zend_Validate_Exception;

class AddPokemonNameAttribute implements DataPatchInterface
{
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory $eavSetupFactory
    ) {}

    /**
     * @return void
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            ConfigRepositoryInterface::POKEMON_NAME_ATTRIBUTE_CODE,
            [
                'type' => 'varchar',
                'label' => 'Pokemon Name',
                'input' => 'text',
                'frontend' => '',
                'required' => false,
                'sort_order' => '10',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'searchable' => true,
                'filterable' => false,
                'is_unique' => true,
                'visible_on_front' => true,
                'group' => 'General',
                'used_in_product_listing' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'visible_in_advanced_search' => true,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
