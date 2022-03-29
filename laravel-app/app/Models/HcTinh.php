<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class HcTinh extends HcBase
{
    use HasFactory;

    protected $table = 'pg_tinh_tp';

    protected $fillable = ['ma', 'ten', 'cap'];

    public $timestamps = false;

    public function quans(): HasMany
    {
        return $this->hasMany(HcQuan::class, 'ma_tp', 'ma');
    }

    public function phuongs()
    {
        return $this->hasManyThrough(
            HcPhuong::class,
            HcQuan::class,
            'ma_tp',
            'ma_qh',
            'ma',
            'ma',
        );
    }

    public static function getDirMatinh(){
        return static::cacheFor(now()->addDays(30))->orderBy('ma')->get(['ma', 'ten'])->pluck('ten', 'ma')->toArray();
    }
}
