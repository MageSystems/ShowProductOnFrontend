<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Block\Adminhtml\Product\Edit\Button;

use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use Magento\Ui\Component\Control\Container;
use MageSystems\ShowProductOnFrontend\Model\Services\Url;
use MageSystems\ShowProductOnFrontend\Model\Services\Visibility;

class ShowOnFrontend extends Generic
{
    protected UrlInterface $urlBuilder;
    protected Visibility $visibility;
    protected Url $urlService;

    public function __construct(
        Context $context,
        Registry $registry,
        UrlInterface $urlBuilder,
        Visibility $visibility,
        Url $urlService
    )
    {
        parent::__construct($context, $registry);
        $this->urlBuilder = $urlBuilder;
        $this->visibility = $visibility;
        $this->urlService = $urlService;
    }

    public function getButtonData()
    {
        $product = $this->getProduct();
        if(! $this->visibility->isVisibleOnFrontend((int) $product->getVisibility())){
            return [];
        }

        return [
            'label' => __('Show on Frontend'),
            //'on_click' => sprintf("location.href = '%s';", $this->getFrontUrl()),
            'class' => 'action-secondary',
            'sort_order' => -1,
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions($product)
        ];
    }

    /**
     * @param Product $product
     * @return array
     */
    private function getOptions(Product $product): array
    {
        $websiteIds = $product->getData('website_ids');
        $urls = array_unique($this->urlService->getProductUrls($websiteIds, (int)$product->getId()));
        $options = [];
        foreach($urls as $siteName => $url){
            $options[] = [
                'label' => $siteName,
                'onclick' => sprintf("location.href = '%s';", $url)
            ];
        }

        return $options;
    }
}
