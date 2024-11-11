<?php

namespace Enhavo\Bundle\SearchBundle\Filter;

use Enhavo\Component\Type\AbstractContainerType;

/**
 * @property FilterTypeInterface $type
 * @property FilterTypeInterface[] $parents
 */
class Filter extends AbstractContainerType
{
    /** @return FilterData[] */
    public function getFilterData($model): array
    {
        $filterDataBuilder = new FilterDataBuilder();

        foreach ($this->parents as $parent) {
            $parent->buildFilter($this->options, $model, $this->key, $filterDataBuilder);
        }

        $this->type->buildFilter($this->options, $model, $this->key, $filterDataBuilder);

        return $filterDataBuilder->getData();
    }

    /** @return FilterField[] */
    public function getFilterFields(): array
    {
        $filterDataBuilder = new FilterDataBuilder();

        foreach ($this->parents as $parent) {
            $parent->buildField($this->options, $this->key, $filterDataBuilder);
        }

        $this->type->buildField($this->options, $this->key, $filterDataBuilder);

        return $filterDataBuilder->getFields();
    }
}
