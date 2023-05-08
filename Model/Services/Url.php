<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Model\Services;

use Magento\Framework\UrlInterface;

class Url
{
    protected UrlInterface $urlBuilder;
    protected StoreResolver $storeResolver;

    public function __construct(UrlInterface $urlBuilder, StoreResolver $storeResolver)
    {
        $this->urlBuilder = $urlBuilder;
        $this->storeResolver = $storeResolver;
    }

    /**
     * @param array $websiteIds
     * @param int $productId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductUrls(array $websiteIds, int $productId): array
    {
        $urls = [];
        foreach($websiteIds as $websiteId){
            $stores = $this->storeResolver->getStoreByWebsiteId((int) $websiteId);
            foreach($stores as $store) {
                if($store->getIsActive()) {
                    $urls[$store->getName()] = $this->urlBuilder->getUrl('catalog/product/view', ['id' => $productId, '_scope' => $store->getId()]);
                }
            }
        }

        return $urls;
    }
}
