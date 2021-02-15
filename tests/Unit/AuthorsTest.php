<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorsTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
     public function a_name_should_be_required()
     {
        Author::firstOrCreate([
            'name' => 'Rodriguez'
        ]);

        $this->assertCount(1, Author::all());
     }
}
