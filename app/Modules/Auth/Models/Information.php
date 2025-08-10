<?php

namespace App\Modules\Auth\Models;

use App\Core\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Information extends Model
{
    protected $fillable = [
        'phone',
        'business_name',
        'presenter_phone',
        'province_id',
        'city_id',
        'address',
        'avatar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function _lastVd()
    {
        $v = new Verta($this->last_vd);

        return $v->formatDatetime();
    }

    public function remainDays()
    {
        $lastVd = $this->last_vd;
        if (! $lastVd) {
            return 0;
        }

        if (! $this->days) {
            return 0;
        }

        $lastVdDate = new Carbon($lastVd);
        $aDays = $lastVdDate->diffInDays(now());

        return ((int) $this->days) - $aDays;
    }

    public function isActive(): bool
    {
        return $this->active == 1;
    }

    public function isBan(): bool
    {
        return $this->ban == 1;
    }

    public function accountDisabled(): bool
    {
        return ! $this->computeIsActive() or $this->isBan();
    }

    public function panelExpireDate()
    {
        $lastVd = $this->last_vd;
        $date = new Carbon($lastVd);
        $date->addDays((int) $this->days);

        return $date->toDateTimeString();
    }

    public function _panelExpireDate()
    {
        $v = new Verta($this->panelExpireDate());

        return $v->formatDatetime();
    }
}
