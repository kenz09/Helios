<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'title','description','owner_id'
    ];

    /**
     * The relationship to owned tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    /**
     * The relationship to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
