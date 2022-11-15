<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $utm_source
 */
class Partner extends Model
{
    use HasFactory;
    public $timestamps = false;
}
