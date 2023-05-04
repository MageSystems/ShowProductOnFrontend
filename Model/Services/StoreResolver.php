<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Model\Services;

use Magento\Store\Model\StoreManagerInterface;

class StoreResolver
{
    protected StoreManagerInterface $storeManager;
    private array $storeCache = [];

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    public function getStoreByWebsiteId(int $websiteId)
    {
        if(!isset($this->storeCache[$websiteId])) {
            $this->storeCache[$websiteId] = $this->storeManager->getWebsite($websiteId)->getStores();
        }

        return $this->storeCache[$websiteId];
    }
}
