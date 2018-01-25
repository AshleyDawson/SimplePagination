<?php

namespace AshleyDawson\SimplePagination\Tests;

use AshleyDawson\SimplePagination\Pagination;
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

        $this->setExpectedException('AshleyDawson\SimplePagination\Exception\CallbackNotFoundException');

        $this->paginator->paginate('1');
    }

    public function testPaginateFailZeroPageNumber()
    {
        $this->setExpectedException('AshleyDawson\SimplePagination\Exception\InvalidPageNumberException');

        $this->setExpectedException('AshleyDawson\SimplePagination\Exception\CallbackNotFoundException');

        $this->paginator->paginate(0);
    }

    public function testBeforeAndAfterQueryCallbacks()
    {
        $items = range(0, 27);

        $paginator = new Paginator(array(
            'itemTotalCallback' => function () use ($items) {
                return count($items);
            },
            'sliceCallback' => function ($offset, $length) use ($items) {
                return array_slice($items, $offset, $length);
            },
            'itemsPerPage' => 10,
            'pagesInRange' => 5,
        ));

        $beforeQueryFired = false;
        $paginator->setBeforeQueryCallback(function () use (&$beforeQueryFired) {
            $beforeQueryFired = true;
        });

        $afterQueryFired = false;
        $paginator->setAfterQueryCallback(function () use (&$afterQueryFired) {
            $afterQueryFired = true;
        });

        $this->assertFalse($beforeQueryFired);
        $this->assertFalse($afterQueryFired);

        $paginator->paginate(1);

        $this->assertTrue($beforeQueryFired);
        $this->assertTrue($afterQueryFired);
    }

    public function testPaginateLowVolumeConstructorConfig()
    {
        $items = range(0, 27);

        $paginator = new Paginator(array(
            'itemTotalCallback' => function () use ($items) {
                return count($items);
            },
            'sliceCallback' => function ($offset, $length) use ($items) {
                return array_slice($items, $offset, $length);
            },
            'itemsPerPage' => 10,
            'pagesInRange' => 5,
        ));

        $pagination = $paginator->paginate(1);

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
        $pagination = $paginator->paginate(2);

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
        $pagination = $paginator->paginate(3);

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

    public function testPaginationIteratorAggregate()
    {
        $items = range(0, 27);

        $paginator = new Paginator(array(
            'itemTotalCallback' => function () use ($items) {
                return count($items);
            },
            'sliceCallback' => function ($offset, $length) use ($items) {
                return array_slice($items, $offset, $length);
            },
            'itemsPerPage' => 15,
            'pagesInRange' => 5,
        ));

        $pagination = $paginator->paginate(1);

        $this->assertInstanceOf('\IteratorAggregate', $pagination);

        $this->assertInstanceOf('\Countable', $pagination);

        $this->assertCount(15, $pagination);

        $iterations = 0;
        foreach ($pagination as $i => $item) {
            $this->assertEquals($i, $item);
            $iterations ++;
        }

        $this->assertEquals(15, $iterations);
    }

    public function testPaginateLowVolume()
    {
        $items = range(0, 27);

        $this->paginator->setItemsPerPage(10)->setPagesInRange(5);

        $this->paginator->setItemTotalCallback(function (Pagination $pagination) use ($items) {
            $pagination->setMeta(array('meta_1'));
            return count($items);
        });

        $this->paginator->setSliceCallback(function ($offset, $length, Pagination $pagination) use ($items) {
            $pagination->setMeta(array_merge($pagination->getMeta(), array('meta_2')));
            return array_slice($items, $offset, $length);
        });

        $pagination = $this->paginator->paginate(1);

        $this->assertContains('meta_1', $pagination->getMeta());
        $this->assertContains('meta_2', $pagination->getMeta());

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

        $this->assertContains('meta_1', $pagination->getMeta());
        $this->assertContains('meta_2', $pagination->getMeta());
    }

    public function testPaginateHighVolume()
    {
        // CAUTION: This test consumes a large amount of memory (~50Mb) in PHP 5

        $items = range(0, 293832);

        $this->paginator->setItemsPerPage(10)->setPagesInRange(5);

        $this->paginator->setItemTotalCallback(function (Pagination $pagination) use ($items) {
            $pagination->setMeta(array('meta_3'));
            return count($items);
        });

        $this->paginator->setSliceCallback(function ($offset, $length, Pagination $pagination) use ($items) {
            $pagination->setMeta(array_merge($pagination->getMeta(), array('meta_4')));
            return array_slice($items, $offset, $length);
        });

        $pagination = $this->paginator->paginate(1);

        $this->assertContains('meta_3', $pagination->getMeta());
        $this->assertContains('meta_4', $pagination->getMeta());

        $this->assertCount(10, $pagination->getItems());

        $this->assertCount(5, $pagination->getPages());

        $this->assertEquals(29384, $pagination->getTotalNumberOfPages());

        $this->assertEquals(1, $pagination->getCurrentPageNumber());

        $this->assertEquals(1, $pagination->getFirstPageNumber());

        $this->assertEquals(29384, $pagination->getLastPageNumber());

        $this->assertNull($pagination->getPreviousPageNumber());

        $this->assertEquals(2, $pagination->getNextPageNumber());

        $this->assertEquals(10, $pagination->getItemsPerPage());

        $this->assertEquals(293833, $pagination->getTotalNumberOfItems());

        $this->assertEquals(1, $pagination->getFirstPageNumberInRange());

        $this->assertEquals(5, $pagination->getLastPageNumberInRange());

        // Move to random page
        $pagination = $this->paginator->paginate(4573);

        $this->assertCount(10, $pagination->getItems());

        $this->assertCount(5, $pagination->getPages());

        $this->assertEquals(29384, $pagination->getTotalNumberOfPages());

        $this->assertEquals(4573, $pagination->getCurrentPageNumber());

        $this->assertEquals(1, $pagination->getFirstPageNumber());

        $this->assertEquals(29384, $pagination->getLastPageNumber());

        $this->assertEquals(4572, $pagination->getPreviousPageNumber());

        $this->assertEquals(4574, $pagination->getNextPageNumber());

        $this->assertEquals(10, $pagination->getItemsPerPage());

        $this->assertEquals(293833, $pagination->getTotalNumberOfItems());

        $this->assertEquals(4571, $pagination->getFirstPageNumberInRange());

        $this->assertEquals(4575, $pagination->getLastPageNumberInRange());

        // Move to last page
        $pagination = $this->paginator->paginate(29384);

        $this->assertCount(3, $pagination->getItems());

        $this->assertCount(5, $pagination->getPages());

        $this->assertEquals(29384, $pagination->getTotalNumberOfPages());

        $this->assertEquals(29384, $pagination->getCurrentPageNumber());

        $this->assertEquals(1, $pagination->getFirstPageNumber());

        $this->assertEquals(29384, $pagination->getLastPageNumber());

        $this->assertEquals(29383, $pagination->getPreviousPageNumber());

        $this->assertNull($pagination->getNextPageNumber());

        $this->assertEquals(10, $pagination->getItemsPerPage());

        $this->assertEquals(293833, $pagination->getTotalNumberOfItems());

        $this->assertEquals(29380, $pagination->getFirstPageNumberInRange());

        $this->assertEquals(29384, $pagination->getLastPageNumberInRange());

        $this->assertContains('meta_3', $pagination->getMeta());
        $this->assertContains('meta_4', $pagination->getMeta());
    }
}