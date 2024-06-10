<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{

    use SoftDeletes;

    protected $table = 'clients';
    protected $guarded=['id'];
}
