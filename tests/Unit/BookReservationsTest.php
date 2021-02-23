<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);

        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_returned()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals($book->id, Reservation::first()->book_id);

        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }
}
