<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';


    protected $fillable = ['title', 'owner'];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_teams','team_id','user_id')->withPivot('owner');
    }









}