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
    }

    public function testSetItemsPerPage()
    {
        $this->paginator->setItemsPerPage(45);

        $this->assertEquals(45, $this->paginator->getItemsPerPage());
    }
}