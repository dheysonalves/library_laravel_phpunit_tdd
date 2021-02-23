<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    // It protects against any field injection into the database
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'title',
        'author_id'
    ];

    public function path()
    {
        return '/books/' . $this->id;
    }

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author
        ]))->id;
    }

    public function checkout(User $user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin(User $user)
    {
        $reservation = $this->reservations()
        ->where('user_id', $user->id)
        ->whereNotNull('checked_out_at')
        ->whereNull('checked_in_at')
        ->first();

        $reservation->update([
            'checked_in_at' => now()
        ]);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
