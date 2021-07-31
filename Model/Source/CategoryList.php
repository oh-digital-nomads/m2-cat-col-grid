<?php
declare(strict_types=1);

namespace OH\CategoryColumnProductGrid\Model\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class CategoryList
 * @package OH\CategoryColumnProductGrid\Model\Source
 */
class CategoryList implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $categoryCollectionFactory;

    private $options;

    public function __construct(
        CollectionFactory $collectionFactory
    )
    {
        $this->categoryCollectionFactory = $collectionFactory;
    }

    /**
     * Category options
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray()
    {
        if ($this->options) {
            return $this->options;
        }

        $collection = $this->categoryCollectionFactory
            ->create()
            ->addAttributeToSelect('name')
            ->setOrder('name', 'ASC');

        $this->options[] = ['label' => __('-- Please Select a Category --'), 'value' => ''];

        foreach ($collection as $category) {
            $this->options[] = ['label' => $category->getName(), 'value' => $category->getId()];
        }

        return $this->options;
    }
}
