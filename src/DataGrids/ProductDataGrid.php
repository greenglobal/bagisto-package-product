<?php

namespace GGPHP\Admin\DataGrids;

use Webkul\Admin\DataGrids\ProductDataGrid as WebkulProductDataGrid;

class ProductDataGrid extends WebkulProductDataGrid
{
    public function prepareQueryBuilder()
    {
        parent::prepareQueryBuilder();
        $queryBuilder = $this->queryBuilder;
        $isShowParentProduct = core()->getConfigData('catalog.products.general.show-parent-product-only');
        // Get parent products only
        if ($isShowParentProduct) {
            $queryBuilder->whereNull('products.parent_id');
        }
        $this->setQueryBuilder($queryBuilder);
    }
}
