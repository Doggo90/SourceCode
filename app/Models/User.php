<?php

namespace App\Models;


use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function sessionCheck(){
        if (Auth::check()) {
            return optional(auth()->user())->status == 'active';
        } else {
            return false;
        }
    }



    public function scopeFilter($query, $value){

        $query-> where('name', 'like', '%' . $value . '%')
        ->orWhere('email', 'like', '%' . $value . '%')
        ->orWhere('phone', 'like', '%' . $value . '%')
        ->orWhere('role', 'like', '%' . $value . '%');

    }
    public static function generateUsername($username){
        if($username === null){
            $username = Str::lower(Str::random(8));
        }
        if(User::where('username',$username)->exists()){
            $newUsername = Str::lower(Str::random(8));
            $username = $newUsername.Str::lower(Str::random(3));
        }
        return $username;
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    public function getProfileLinkAttribute()
    {
        return route('profile', ['id' => $this->id]);
    }


    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function likes(){
        return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    }
    public function hasUpvoted(Post $post){
        return $this->likes()->where('post_id', $post->id)->exists();
    }
    public function totalUpvotes()
    {
        return $this->likes()->count(5);
    }
    public function organizations(): belongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->role, 'admin') || str_ends_with($this->role, 'agent');
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function mentions()
    {
        return $this->belongsToMany(Reply::class, 'reply_user', 'user_id', 'reply_id')
                    ->withTimestamps();
    }
    public function commentMentions()
    {
        return $this->belongsToMany(Comment::class, 'comment_user', 'user_id', 'comment_id')
                    ->withTimestamps();
    }
}
