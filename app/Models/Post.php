<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;


    // protected $fillable = ['title', 'body', 'tags', 'user_id' , 'is_archived','comments_count', 'selectedCategories'];
    protected $guarded = [];
    public function scopeSearch($query, $value){
        // $query-> where('tags', 'like', "%{{$value}}%");

        // if($value['search'] ?? false){
        //
        // }
        $query->where('title', 'like', '%' . $value . '%')
        ->orWhere('body', 'like', '%' . $value . '%')
        ->orWhereHas('author', function ($subQuery) use ($value) {
            $subQuery
                ->where('name', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%')
                ->orWhere('phone', 'like', '%' . $value . '%');
        });

    }
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $user = $post->user;
            $user->increment('reputation', 1);
        });
    }
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function categories(): belongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category')->withTimestamps();
    }
    public function likes(){
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }
}
