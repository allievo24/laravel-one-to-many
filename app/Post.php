<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $fillable=['title','content','slug','category_id'];

   /*Relazione tra i 2 model (post e category)*/
   public function category(){
      return $this->belongsTo('App\Category');
   }  



}
