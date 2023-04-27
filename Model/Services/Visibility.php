<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Model\Services;

use Magento\Catalog\Model\Product\Visibility as MagentoVisibility;

class Visibility
{
    protected MagentoVisibility $visibility;

    public function __construct(MagentoVisibility $visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Checks if a product visible on the frontend
     *
     * @param int $visibility
     * @return bool
     */
    public function isVisibleOnFrontend(int $visibility): bool
    {
        $visibilities = $this->visibility->getVisibleInSiteIds();

        return in_array($visibility, $visibilities);
    }
}
