<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //Tablo adı
    protected $table = 'Contacts';
    //Birincil anahtar
    public $primarykey = 'id';
    //Zamanlar
    public $timestamps = true;

}
