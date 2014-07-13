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
        // todo: finish this test
    }
}