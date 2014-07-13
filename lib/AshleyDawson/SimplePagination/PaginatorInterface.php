<?php

namespace AshleyDawson\SimplePagination;

/**
 * Interface PaginatorInterface
 *
 * @package AshleyDawson\SimplePagination
 * @author Ashley Dawson <ashley@ashleydawson.co.uk>
 */
interface PaginatorInterface
{
    /**
     * Run paginate algorithm using the current page number
     *
     * @param int $currentPageNumber Page number, usually passed from the current request
     * @return Pagination Collection of items returned by the slice callback with pagination meta information
     * @throws \InvalidArgumentException
     * @throws \AshleyDawson\SimplePagination\Exception\InvalidPageNumberException
     */
    public function paginate($currentPageNumber = 1);

    /**
     * Get sliceCallback
     *
     * @return callable
     */
    public function getSliceCallback();

    /**
     * Set sliceCallback
     *
     * @param callable $sliceCallback
     * @return $this
     */
    public function setSliceCallback(\Closure $sliceCallback);

    /**
     * Get itemTotalCallback
     *
     * @return callable
     */
    public function getItemTotalCallback();

    /**
     * Set itemTotalCallback
     *
     * @param callable $itemTotalCallback
     * @return $this
     */
    public function setItemTotalCallback(\Closure $itemTotalCallback);

    /**
     * Get itemsPerPage
     *
     * @return int
     */
    public function getItemsPerPage();

    /**
     * Set itemsPerPage
     *
     * @param int $itemsPerPage
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setItemsPerPage($itemsPerPage);

    /**
     * Get pagesInRange
     *
     * @return int
     */
    public function getPagesInRange();

    /**
     * Set pagesInRange
     *
     * @param int $pagesInRange
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setPagesInRange($pagesInRange);
}