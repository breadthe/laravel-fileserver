<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class File extends Model
{
    use HasFactory;

    const FOLDER = 'files'; // the default folder where files are stored

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        // Generate a UUID when the model object is created
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

    /**
     * The file path on disk (files/user_uuid/original_file_name.extension)
     * Example: files/87c284bc-31ba-4786-9edd-29e9df6e09ed/angry+cat.jpg
     */
    public function path()
    {
        return sprintf("%s/%s/%s", self::FOLDER, $this->user->uuid, urlencode($this->name));
    }

    public function trackDownload(Request $request)
    {
        Download::create([
            'file_id' => $this->id,
            'uuid' => $this->uuid,
            'by_owner' => $this->user_id === auth()->id(),
            'path' => $this->path(),
            'name' => $this->name,
            'ip' => $request->ip(),
            'meta' => null,
        ]);
    }
}
