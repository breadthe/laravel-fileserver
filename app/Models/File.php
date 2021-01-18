<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        // Set the User id when the model object is created
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4(); // random UUID
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
