<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Model\Services;

use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class StoreResolver
{
    protected StoreManagerInterface $storeManager;
    private array $storeCache = [];

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param int $websiteId
     * @return array|mixed
     * @throws LocalizedException
     */
    public function getStoreByWebsiteId(int $websiteId)
    {
        if(!isset($this->storeCache[$websiteId])) {
            $this->storeCache[$websiteId] = $this->storeManager->getWebsite($websiteId)->getStores();
        }

        return $this->storeCache[$websiteId];
    }
}
