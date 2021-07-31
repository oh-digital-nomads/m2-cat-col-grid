<?php

declare(strict_types=1);

namespace OH\CategoryColumnProductGrid\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Category
 * @package OH\CategoryColumnProductGrid\Ui\Component\Listing\Column
 */
class Category extends Column
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            $product = $this->productCollectionFactory
                ->create()
                ->addFieldToFilter('entity_id', $item['entity_id'])
                ->getFirstItem();

            if (!$cats = $product->getCategoryIds()) {
                continue;
            }

            $categories = [];

            foreach ($cats as $cat) {
                $category = $this->categoryCollectionFactory
                    ->create()
                    ->addAttributeToSelect('name')
                    ->addFieldToFilter('entity_id', $cat)
                    ->getFirstItem();
                $categories[$cat] = $category->getName();
            }

            $item[$fieldName] = implode(' / ', $categories);
        }

        return $dataSource;
    }
}
