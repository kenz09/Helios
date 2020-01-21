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

    /**
     * The relationship to many admins
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins(){
        return $this->belongsToMany(User::class, 'project_admin', 'project_id','user_id');
    }

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
