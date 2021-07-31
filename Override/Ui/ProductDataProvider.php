<?php
declare(strict_types=1);

namespace OH\CategoryColumnProductGrid\Override\Ui;

/**
 * Class ProductDataProvider
 * @package OH\CategoryColumnProductGrid\Override\Ui
 */
class ProductDataProvider extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    /**
     * {@inheritdoc}
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if ($filter->getField() != 'category_id') {
            return parent::addFilter($filter);
        }

        $this->getCollection()->addCategoriesFilter(array('in' => $filter->getValue()));
    }
}
