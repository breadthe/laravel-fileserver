<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function trackDownload(Request $request)
    {
        Download::create([
            'file_id' => $this->id,
            'uuid' => $this->uuid,
            'by_owner' => $this->user_id === auth()->id(),
            'path' => $this->path,
            'name' => $this->name,
            'ip' => $request->ip(),
            'meta' => null,
        ]);
    }
}
