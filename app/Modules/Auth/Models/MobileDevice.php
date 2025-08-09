<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class MobileDevice extends Model
{
    protected $table = 'user_mobile_devices';

    protected $fillable = [
        'user_id',
        'device_info',
        'date',
    ];
}
