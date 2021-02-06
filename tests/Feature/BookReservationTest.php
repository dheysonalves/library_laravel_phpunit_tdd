<?php

namespace Tests\Feature;

use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class BookReservationTest extends TestCase
{
    // Refresh the database with migrations
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'The book title',
            'author' => 'Dheyson'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Dheyson'
        ]);

        $response->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_author_is_required()
    {

        $response = $this->post('/books', [
            'title' => 'The book title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Dheyson'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */
    public function a_book_can_be_deleted()
    {

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Dheyson'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
