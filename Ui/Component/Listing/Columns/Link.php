<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use MageSystems\ShowProductOnFrontend\Model\Services\Url;
use MageSystems\ShowProductOnFrontend\Model\Services\Visibility;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Link extends Column
{
    protected Visibility $visibility;
    protected Url $urlService;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Url $urlService,
        Visibility $visibility,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->visibility = $visibility;
        $this->urlService = $urlService;
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource["data"]["items"])) {
            $fieldName = $this->getData("name");
            foreach ($dataSource["data"]["items"] as $key => $item)  {
                if($this->visibility->isVisibleOnFrontend((int)$item['visibility'])) {
                    $websiteIds = $item['website_ids'] ?? [];
                    $urls = array_unique($this->urlService->getProductUrls($websiteIds, (int)$item['entity_id']));

                    $dataSource["data"]["items"][$key][$fieldName] = $urls;
                }
            }

        }

        return $dataSource;
    }
}
