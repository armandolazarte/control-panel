<?php

namespace Tests\Unit;

use App\Sortable;
use Tests\TestCase;

class SortableTest extends TestCase
{
    protected $sortable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sortable = new Sortable('http://localhost/demo');
    }

    /** @test */
    function builds_a_url_with_sortable_date()
    {
       $this->assertSame(
            'http://localhost/demo?order=name&direction=asc',
            $this->sortable->url('name')
        );
    }

    /** @test */
    function appends_query_data_to_the_url()
    {
        $this->sortable->appends(['a' => 'parameter', 'and' => 'another-parameter']);

        $this->assertSame(
            'http://localhost/demo?a=parameter&and=another-parameter&order=name&direction=asc',
            $this->sortable->url('name')
        );
    }

    /** @test */
    function builds_a_url_with_desc_order_if_the_current_column_matches_the_given_one_and_the_current_direction_is_asc()
    {
        $this->sortable->appends(['order' => 'name', 'direction' => 'asc']);

        $this->assertSame(
            'http://localhost/demo?order=name&direction=desc',
            $this->sortable->url('name')
        );
    }

    /** @test */
    function returns_a_css_class_to_indicate_the_column_is_sortable()
    {
        $this->assertSame('fa-sort', $this->sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_ascendent_order()
    {
        $this->sortable->appends(['order' => 'name']);

        $this->assertSame('fa-sort-up', $this->sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $this->sortable->appends(['order' => 'name', 'direction' => 'desc']);

        $this->assertSame('fa-sort-down', $this->sortable->classes('name'));
    }
}
