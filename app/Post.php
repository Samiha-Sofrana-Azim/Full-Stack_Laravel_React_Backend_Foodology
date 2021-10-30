<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $fillable = [ 
        'name','file_path','description',
    ]; 
    public function categories(){
        
        return $this->belongsToMany('App\Category');
    }
}
