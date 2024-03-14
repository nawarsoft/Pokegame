<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Plugin;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Image;
use Magento\Catalog\Model\Product;
use Nawarsoft\PokeGame\Service\GetPokemonImageUrl;

class AfterGetImage
{
    /**
     * @param GetPokemonImageUrl $getPokemonImageUrl
     */
    public function __construct(
        private readonly GetPokemonImageUrl $getPokemonImageUrl
    ) {}

    /**
     * @param AbstractProduct $subject
     * @param Image $result
     * @param Product $product
     * @param string $imageId
     * @param array $attributes
     * @return Image
     */
    public function afterGetImage(AbstractProduct $subject, Image $result, Product $product, string $imageId, array $attributes): Image
    {
        $url = $this->getPokemonImageUrl->getByProduct($product);

        if ($url !== '') {
            $result['image_url'] = $url;
        }

        return $result;
    }
}
