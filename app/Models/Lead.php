<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $phone
 * @property $partner_id
 * @property $sending
 * @property $created_at
 * @property $updated_at
 */
class Lead extends Model
{
    use HasFactory, HasUuids;
}
