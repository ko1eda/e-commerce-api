<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CatergoriesTest extends TestCase
{
    public function test_a_collection_of_categories_is_returned_from_index()
    {
        // Given we have two categories
        $categories = factory(Category::class, 2)->create();

        // When we hit the index route, then those two categores should be displayed
        $this->json('GET', route('categories.index'))->assertJsonFragment([
            'name' => $categories[0]->name,
            'name' => $categories[1]->name
        ]);
    }

    
    public function test_only_parent_categories_are_returned_at_top_level_from_index()
    {
        // Given we have two categories
        $parents = factory(Category::class, 2)->create();

        // And one of those categories has a child
        $child = factory(Category::class)->create(['parent_id' => $parents[0]->id]);

        // When we hit our endpoint, our data aray should only contain two top level parent objects
        // ex data : [{name: , slug: , child: [name:, slug:] }, {name: , slug:, child: [] }]
        $this->json('GET', route('categories.index'))->assertJsonCount(2, 'data');
    }


    public function test_parent_categories_are_returned_in_their_given_order_from_index()
    {
        $second = factory(Category::class)->create(['order' => 2]);
        $first = factory(Category::class)->create(['order' => 1]);

        $this->json('GET', route('categories.index'))
            ->assertSeeInOrder([$first->name, $second->name]);
    }
}