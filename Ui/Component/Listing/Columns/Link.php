<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use MageSystems\ShowProductOnFrontend\Model\Services\Visibility;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Link extends Column
{
    protected UrlInterface $urlBuilder;
    protected Visibility $visibility;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Visibility $visibility,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->visibility = $visibility;
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource["data"]["items"])) {
            $fieldName = $this->getData("name");
            foreach ($dataSource["data"]["items"] as $key => $item)  {
                if($this->visibility->isVisibleOnFrontend((int)$item['visibility'])) {
                    $storeId = $this->context->getFilterParam('store_id');
                    $url = $this->urlBuilder->getUrl('catalog/product/view',
                        ['id' => $item['entity_id'], 'store' => $storeId]);

                    $dataSource["data"]["items"][$key][$fieldName] = $url;
                }
            }

        }

        return $dataSource;
    }
}
