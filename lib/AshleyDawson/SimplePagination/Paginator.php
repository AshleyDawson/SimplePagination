<?php

namespace AshleyDawson\SimplePagination;

use AshleyDawson\SimplePagination\Exception\InvalidPageNumberException;

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
    public function paginate($currentPageNumber = 1)
    {
        if (!is_int($currentPageNumber)) {
            throw new \InvalidArgumentException(
                sprintf('Current page number must be of type integer, %s given', gettype($currentPageNumber)));
        }

        if ($currentPageNumber <= 0) {
            throw new InvalidPageNumberException(
                sprintf('Current page number must have a value of 1 or more, %s given', $currentPageNumber));
        }

        $itemTotalCallback = $this->itemTotalCallback;
        $totalNumberOfItems = (int)$itemTotalCallback();

        $numberOfPages = (int)ceil($totalNumberOfItems / $this->itemsPerPage);

        $pagesInRange = $this->pagesInRange;

        if ($pagesInRange > $numberOfPages) {
            $pagesInRange = $numberOfPages;
        }

        $delta = (int)ceil($pagesInRange / 2);

        if ($currentPageNumber - $delta > $numberOfPages - $pagesInRange) {
            $pages = range($numberOfPages - $pagesInRange + 1, $numberOfPages);
        }
        else {
            if ($currentPageNumber - $delta < 0) {
                $delta = $currentPageNumber;
            }
            $offset = $currentPageNumber - $delta;
            $pages = range($offset + 1, $offset + $pagesInRange);
        }

        $offset = ($currentPageNumber - 1) * $this->itemsPerPage;

        $sliceCallback = $this->sliceCallback;
        $items = $sliceCallback($offset, $this->itemsPerPage);

        // todo: finish algorithm

        // todo: check that callbacks return an iterable collection (e.g. array, \ArrayIterator, etc.)

        // todo: write a class to represent the result set
    }

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
    public function setItemTotalCallback(\Closure $itemTotalCallback)
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