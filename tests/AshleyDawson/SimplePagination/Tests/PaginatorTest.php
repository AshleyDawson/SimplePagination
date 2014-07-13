<?php

namespace AshleyDawson\SimplePagination\Tests;

use AshleyDawson\SimplePagination\Paginator;

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Paginator
     */
    protected $paginator;

    protected function setUp()
    {
        $this->paginator = new Paginator();
    }

    public function testSetSliceCallback()
    {
        $this->paginator->setSliceCallback(function () {
            return 'slice_callback';
        });

        $callback = $this->paginator->getSliceCallback();

        $this->assertInstanceOf('\Closure', $callback);

        $this->assertEquals('slice_callback', $callback());
    }

    public function testSetItemTotalCallback()
    {
        $this->paginator->setItemTotalCallback(function () {
            return 'item_total_callback';
        });

        $callback = $this->paginator->getItemTotalCallback();

        $this->assertInstanceOf('\Closure', $callback);

        $this->assertEquals('item_total_callback', $callback());
    }

    public function testSetItemsPerPageFail()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->paginator->setItemsPerPage(45.8);

        $this->assertNotNull($this->paginator->getItemsPerPage());
    }

    public function testSetItemsPerPage()
    {
        $this->paginator->setItemsPerPage(45);

        $this->assertEquals(45, $this->paginator->getItemsPerPage());
    }

    public function testSetPagesInRangeFail()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->paginator->setPagesInRange(23.7);

        $this->assertNotNull($this->paginator->getPagesInRange());
    }

    public function testSetPagesInRange()
    {
        $this->paginator->setPagesInRange(23);

        $this->assertEquals(23, $this->paginator->getPagesInRange());
    }

    public function testPaginateFailNotInteger()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->paginator->paginate('1');
    }

    public function testPaginateFailZeroPageNumber()
    {
        $this->setExpectedException('AshleyDawson\SimplePagination\Exception\InvalidPageNumberException');

        $this->paginator->paginate(0);
    }

    public function testPaginate()
    {
        $items = range(0, 27);

        $this->paginator->setItemTotalCallback(function () use ($items) {
            return count($items);
        });

        $this->paginator->setSliceCallback(function ($offset, $length) use ($items) {
            return array_slice($items, $offset, $length);
        });

        $pagination = $this->paginator->paginate(1);

        $this->assertCount(10, $pagination->getItems());

        $this->assertCount(3, $pagination->getPages());

        $this->assertEquals(3, $pagination->getTotalNumberOfPages());

        $this->assertEquals(1, $pagination->getCurrentPageNumber());

        $this->assertEquals(1, $pagination->getFirstPageNumber());

        $this->assertEquals(3, $pagination->getLastPageNumber());

        $this->assertNull($pagination->getPreviousPageNumber());

        $this->assertEquals(2, $pagination->getNextPageNumber());

        $this->assertEquals(10, $pagination->getItemsPerPage());

        $this->assertEquals(28, $pagination->getTotalNumberOfItems());

        $this->assertEquals(1, $pagination->getFirstPageNumberInRange());

        $this->assertEquals(3, $pagination->getLastPageNumberInRange());

        // Increment page
        $pagination = $this->paginator->paginate(2);

        $this->assertCount(10, $pagination->getItems());

        $this->assertCount(3, $pagination->getPages());

        $this->assertEquals(3, $pagination->getTotalNumberOfPages());

        $this->assertEquals(2, $pagination->getCurrentPageNumber());

        $this->assertEquals(1, $pagination->getFirstPageNumber());

        $this->assertEquals(3, $pagination->getLastPageNumber());

        $this->assertEquals(1, $pagination->getPreviousPageNumber());

        $this->assertEquals(3, $pagination->getNextPageNumber());

        $this->assertEquals(10, $pagination->getItemsPerPage());

        $this->assertEquals(28, $pagination->getTotalNumberOfItems());

        $this->assertEquals(1, $pagination->getFirstPageNumberInRange());

        $this->assertEquals(3, $pagination->getLastPageNumberInRange());

        // Increment page
        $pagination = $this->paginator->paginate(3);

        $this->assertCount(8, $pagination->getItems());

        $this->assertCount(3, $pagination->getPages());

        $this->assertEquals(3, $pagination->getTotalNumberOfPages());

        $this->assertEquals(3, $pagination->getCurrentPageNumber());

        $this->assertEquals(1, $pagination->getFirstPageNumber());

        $this->assertEquals(3, $pagination->getLastPageNumber());

        $this->assertEquals(2, $pagination->getPreviousPageNumber());

        $this->assertNull($pagination->getNextPageNumber());

        $this->assertEquals(10, $pagination->getItemsPerPage());

        $this->assertEquals(28, $pagination->getTotalNumberOfItems());

        $this->assertEquals(1, $pagination->getFirstPageNumberInRange());

        $this->assertEquals(3, $pagination->getLastPageNumberInRange());
    }
}