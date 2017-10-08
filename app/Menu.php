<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table = 'menu';

    public function Menu()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }
}
