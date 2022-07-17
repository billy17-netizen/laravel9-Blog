<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{

    use hasFactory;

   protected $fillable = [
      'title',
      'slug',
      'excerpt',
      'body',
      'user_id',
       'category_id',
       'approved'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //scope function
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }
}
