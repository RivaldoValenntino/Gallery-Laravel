<?php

namespace App\Models;

use App\Events\AlbumStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if ($model->isDirty('cover') && ($model->getOriginal('cover') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('cover'));
            }
        });
    }
    protected static function booted()
    {
        static::updated(function ($album) {
            if ($album->isDirty('status')) {
                $album->photos()->update(['status' => $album->status]);
            }
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}