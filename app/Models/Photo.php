<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tags' => 'array',
    ];


    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if ($model->isDirty('gambar') && ($model->getOriginal('gambar') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('gambar'));
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'like_photo')->withTimestamps();
    }
    public function scopeSearch($query, array $searchTerm)
    {
        $query->when($searchTerm['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%' . $search . '%');
            });
        });

        $query->when($searchTerm['categories'] ?? false, function ($query, $category) {
            return $query->whereHas('categories', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });
    }
}