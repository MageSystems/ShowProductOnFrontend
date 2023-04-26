<?php

declare(strict_types=1);

namespace MageSystems\ShowProductOnFrontend\Block\Adminhtml\Product\Edit\Button;

use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use MageSystems\ShowProductOnFrontend\Model\Services\Visibility;

class ShowOnFrontend extends Generic
{
    protected UrlInterface $urlBuilder;
    protected Visibility $visibility;

    public function __construct(
        Context $context,
        Registry $registry,
        UrlInterface $urlBuilder,
        Visibility $visibility
    )
    {
        parent::__construct($context, $registry);
        $this->urlBuilder = $urlBuilder;
        $this->visibility = $visibility;
    }

    public function getButtonData()
    {
        $product = $this->getProduct();
        if(! $this->visibility->isVisibleOnFrontend((int) $product->getVisibility())){
            return [];
        }

        return [
            'label' => __('Show on Frontend'),
            'on_click' => sprintf("location.href = '%s';", $this->getFrontUrl()),
            'class' => '',
            'sort_order' => 15,
        ];
    }

    /**
     * Get URL for frontend
     *
     * @return string
     */
    private function getFrontUrl()
    {
        $product = $this->getProduct();

        if($product->getId()){
            return $this->urlBuilder->getUrl('catalog/product/view', ['id' => $product->getId(), 'store' => null]);
        }
    }
}
