<?php

namespace AshleyDawson\SimplePagination;

/**
 * Class Pagination
 *
 * @package AshleyDawson\SimplePagination
 * @author Ashley Dawson <ashley@ashleydawson.co.uk>
 */
class Pagination implements \IteratorAggregate, \Countable
{
    /**
     * @var mixed
     */
    private $items = array();

    /**
     * @var array
     */
    private $pages = array();

    /**
     * @var int
     */
    private $totalNumberOfPages;

    /**
     * @var int
     */
    private $currentPageNumber;

    /**
     * @var int
     */
    private $firstPageNumber;

    /**
     * @var int
     */
    private $lastPageNumber;

    /**
     * @var int|null
     */
    private $previousPageNumber;

    /**
     * @var int|null
     */
    private $nextPageNumber;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $totalNumberOfItems;

    /**
     * @var int
     */
    private $firstPageNumberInRange;

    /**
     * @var int
     */
    private $lastPageNumberInRange;

    /**
     * @var mixed
     */
    private $meta;

    /**
     * Get items
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set items
     *
     * @param mixed $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Get currentPageNumber
     *
     * @return int
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    /**
     * Set currentPageNumber
     *
     * @param int $currentPageNumber
     * @return $this
     */
    public function setCurrentPageNumber($currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    /**
     * Get firstPageNumber
     *
     * @return int
     */
    public function getFirstPageNumber()
    {
        return $this->firstPageNumber;
    }

    /**
     * Set firstPageNumber
     *
     * @param int $firstPageNumber
     * @return $this
     */
    public function setFirstPageNumber($firstPageNumber)
    {
        $this->firstPageNumber = $firstPageNumber;
        return $this;
    }

    /**
     * Get firstPageNumberInRange
     *
     * @return int
     */
    public function getFirstPageNumberInRange()
    {
        return $this->firstPageNumberInRange;
    }

    /**
     * Set firstPageNumberInRange
     *
     * @param int $firstPageNumberInRange
     * @return $this
     */
    public function setFirstPageNumberInRange($firstPageNumberInRange)
    {
        $this->firstPageNumberInRange = $firstPageNumberInRange;
        return $this;
    }

    /**
     * Get itemsPerPage
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Set itemsPerPage
     *
     * @param int $itemsPerPage
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * Get lastPageNumber
     *
     * @return int
     */
    public function getLastPageNumber()
    {
        return $this->lastPageNumber;
    }

    /**
     * Set lastPageNumber
     *
     * @param int $lastPageNumber
     * @return $this
     */
    public function setLastPageNumber($lastPageNumber)
    {
        $this->lastPageNumber = $lastPageNumber;
        return $this;
    }

    /**
     * Get lastPageNumberInRange
     *
     * @return int
     */
    public function getLastPageNumberInRange()
    {
        return $this->lastPageNumberInRange;
    }

    /**
     * Set lastPageNumberInRange
     *
     * @param int $lastPageNumberInRange
     * @return $this
     */
    public function setLastPageNumberInRange($lastPageNumberInRange)
    {
        $this->lastPageNumberInRange = $lastPageNumberInRange;
        return $this;
    }

    /**
     * Get nextPageNumber
     *
     * @return int
     */
    public function getNextPageNumber()
    {
        return $this->nextPageNumber;
    }

    /**
     * Set nextPageNumber
     *
     * @param int $nextPageNumber
     * @return $this
     */
    public function setNextPageNumber($nextPageNumber)
    {
        $this->nextPageNumber = $nextPageNumber;
        return $this;
    }

    /**
     * Get pages
     *
     * @return array
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set pages
     *
     * @param array $pages
     * @return $this
     */
    public function setPages(array $pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Get previousPageNumber
     *
     * @return int
     */
    public function getPreviousPageNumber()
    {
        return $this->previousPageNumber;
    }

    /**
     * Set previousPageNumber
     *
     * @param int $previousPageNumber
     * @return $this
     */
    public function setPreviousPageNumber($previousPageNumber)
    {
        $this->previousPageNumber = $previousPageNumber;
        return $this;
    }

    /**
     * Get totalNumberOfItems
     *
     * @return int
     */
    public function getTotalNumberOfItems()
    {
        return $this->totalNumberOfItems;
    }

    /**
     * Set totalNumberOfItems
     *
     * @param int $totalNumberOfItems
     * @return $this
     */
    public function setTotalNumberOfItems($totalNumberOfItems)
    {
        $this->totalNumberOfItems = $totalNumberOfItems;
        return $this;
    }

    /**
     * Get totalNumberOfPages
     *
     * @return int
     */
    public function getTotalNumberOfPages()
    {
        return $this->totalNumberOfPages;
    }

    /**
     * Set totalNumberOfPages
     *
     * @param int $totalNumberOfPages
     * @return $this
     */
    public function setTotalNumberOfPages($totalNumberOfPages)
    {
        $this->totalNumberOfPages = $totalNumberOfPages;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Get meta
     *
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param mixed $meta
     * @return Pagination
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }
}