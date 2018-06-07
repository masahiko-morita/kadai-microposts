<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'user_favorite', 'user_id', 'favorite_id')->withTimestamps();
    }
    public function favorite($micropostsId)
{
    // confirm if already favoriting
    $exist = $this->is_favoriting($micropostsId);
    
    if ($exist) {
        // do nothing if already favoriting
        return false;
    } else {
        // follow if not following
        $this->favorites()->attach($micropostsId);
        return true;
    }
}

public function unfavorite($micropostsId)
{
    // confirming if already following
    $exist = $this->is_favoriting($micropostsId);
    // confirming that it is not you


    if ($exist) {
        // stop following if following
        $this->favorites()->detach($micropostsId);
        return true;
    } else {
        // do nothing if not following
        return false;
    }
}


public function is_favoriting($micropostsId) {
    return $this->favorites()->where('favorite_id', $micropostsId)->exists();
}
}
