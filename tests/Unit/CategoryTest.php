<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    public function test_it_has_many_children()
    {
        // Given we have a parent category
        $parent = factory(Category::class)->create();

        // and child category
        $parent->children()->save(
            factory(Category::class)->create()
        );
        
        // if we call the hasmany relationship on the parent then we should get 1 child
        $this->assertCount(1, $parent->children);
    }

    public function test_it_can_fetch_only_parents()
    {
        // Given we have a parent category
        $parent = factory(Category::class)->create();

        // And two children
        $children = factory(Category::class, 2)->create(['parent_id' => $parent->id]);
        
        // If we fetch only parents, then there should be no children in the collection
        $this->assertCount(1, Category::parents()->get());
    }

    public function test_it_can_be_sorted_by_order()
    {
        $first = factory(Category::class)->create(['name'=> 'cool', 'order' => 1]);
        $second = factory(Category::class)->create(['order' => 2]);

        $this->assertEquals('cool', Category::orderBy('order', 'asc')->first()->name);
    }
}
