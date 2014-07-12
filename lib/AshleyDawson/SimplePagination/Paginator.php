<?php

namespace AshleyDawson\SimplePagination;

/**
 * Class Paginator
 *
 * @package AshleyDawson\SimplePagination
 * @author Ashley Dawson <ashley@ashleydawson.co.uk>
 */
class Paginator
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
     * Get sliceCallback
     *
     * @return callable
     */
    public function getSliceCallback()
    {
        return $this->sliceCallback;
    }

    /**
     * Set sliceCallback
     *
     * @param callable $sliceCallback
     * @return $this
     */
    public function setSliceCallback(\Closure $sliceCallback)
    {
        $this->sliceCallback = $sliceCallback;
        return $this;
    }

    /**
     * Get itemTotalCallback
     *
     * @return callable
     */
    public function getItemTotalCallback()
    {
        return $this->itemTotalCallback;
    }

    /**
     * Set itemTotalCallback
     *
     * @param callable $itemTotalCallback
     * @return $this
     */
    public function setItemTotalCallback($itemTotalCallback)
    {
        $this->itemTotalCallback = $itemTotalCallback;
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
     * Get pagesInRange
     *
     * @return int
     */
    public function getPagesInRange()
    {
        return $this->pagesInRange;
    }

    /**
     * Set pagesInRange
     *
     * @param int $pagesInRange
     * @return $this
     */
    public function setPagesInRange($pagesInRange)
    {
        $this->pagesInRange = $pagesInRange;
        return $this;
    }
}