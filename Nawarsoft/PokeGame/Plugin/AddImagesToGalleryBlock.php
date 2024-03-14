<?php

declare(strict_types=1);

namespace Nawarsoft\PokeGame\Plugin;

use Exception;
use Magento\Catalog\Block\Product\View\Gallery;
use Magento\Framework\Data\CollectionFactory;
use Magento\Framework\Data\Collection;
use Magento\Framework\DataObject;
use Nawarsoft\PokeGame\Service\GetPokemonImageUrl;
use Psr\Log\LoggerInterface;

class AddImagesToGalleryBlock
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param GetPokemonImageUrl $getPokemonImageUrl
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly GetPokemonImageUrl $getPokemonImageUrl,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @param Gallery $subject
     * @param Collection|null $images
     * @return Collection|null
     * @throws Exception
     */
    public function afterGetGalleryImages(Gallery $subject, ?Collection $images): ?Collection
    {
        try {
            $product = $subject->getProduct();
            $url = $this->getPokemonImageUrl->getByProduct($product);

            if ($url === '') {
                return $images;
            }

            $images = $this->collectionFactory->create();

            $imageId  = uniqid();
            $image = [
                'file' => $url,
                'media_type' => 'image',
                'value_id' => $imageId,
                'row_id' => $imageId,
                'label' => $product->getName(),
                'label_default' => $product->getName(),
                'position' => 100,
                'position_default' => 100,
                'disabled' => 0,
                'url'  => $url,
                'path' => '',
                'small_image_url' => $url,
                'medium_image_url' => $url,
                'large_image_url' => $url
            ];

            $images->addItem(new DataObject($image));

            return $images;

        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Can not load image for product id: %s', $product->getId()),
                [
                    'context' => 'AddImagesToGalleryBlock',
                    'product_id' => $product->getId(),
                    'message' => $e->getTraceAsString(),
                ]
            );
        }
    }
}
