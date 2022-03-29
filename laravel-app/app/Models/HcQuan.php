<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class HcQuan extends HcBase
{
    use HasFactory;

    protected $table = 'pg_quanhuyen';

    public function tinh(): BelongsTo{
        return $this->belongsTo(HcTinh::class, 'ma_tp', 'ma');
    }

    public function phuongs(): HasMany
    {
        return $this->hasMany(HcPhuong::class, 'ma_qh', 'ma');
    }

    public static function getDirQuanByTinh($matinh){
        return HcQuan::where('ma_tp', $matinh)->get(['ma', 'ten'])->sortBy('ten', SORT_NATURAL)->pluck('ten', 'ma');
    }
}
