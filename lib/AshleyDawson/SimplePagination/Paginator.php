<?php

namespace AshleyDawson\SimplePagination;

/**
 * Class Paginator
 *
 * @package AshleyDawson\SimplePagination
 * @author Ashley Dawson <ashley@ashleydawson.co.uk>
 */
class Paginator implements PaginatorInterface
{
    /**
     * @var \Closure
     */
    private $itemTotalCallback;

    /**
     * @var \Closure
     */
    private $sliceCallback;

    /**
     * @var int
     */
    private $itemsPerPage = 10;

    /**
     * @var int
     */
    private $pagesInRange = 5;

    /**
     * {@inheritdoc}
     */
    public function getSliceCallback()
    {
        return $this->sliceCallback;
    }

    /**
     * {@inheritdoc}
     */
    public function setSliceCallback(\Closure $sliceCallback)
    {
        $this->sliceCallback = $sliceCallback;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemTotalCallback()
    {
        return $this->itemTotalCallback;
    }

    /**
     * {@inheritdoc}
     */
    public function setItemTotalCallback($itemTotalCallback)
    {
        $this->itemTotalCallback = $itemTotalCallback;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setItemsPerPage($itemsPerPage)
    {
        if (!is_int($itemsPerPage)) {
            throw new \InvalidArgumentException(
                sprintf('Items per page must be of type integer, %s given', gettype($itemsPerPage)));
        }

        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPagesInRange()
    {
        return $this->pagesInRange;
    }

    /**
     * {@inheritdoc}
     */
    public function setPagesInRange($pagesInRange)
    {
        if (!is_int($pagesInRange)) {
            throw new \InvalidArgumentException(
                sprintf('Pages in range must be of type integer, %s given', gettype($pagesInRange)));
        }

        $this->pagesInRange = $pagesInRange;
        return $this;
    }
}