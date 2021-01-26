<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'alias',
        'name',
        'price',
        'discount',
        'discount_started_at',
        'discount_ended_at'
    ];

    public function options()
    {
        return $this->belongsToMany(Option::class, 'package_options');
    }

    public function getDiscount()
    {
        $date = Carbon::now()->format('Y-m-d');

        if ($this->discount_ended_at && $this->discount_started_at && $date <= Carbon::parse($this->discount_ended_at)->format('Y-m-d') && $date >= Carbon::parse($this->discount_started_at)->format('Y-m-d')) {
            return (int)$this->discount ?? $this->discount;
        }

        return 0;
    }
}
