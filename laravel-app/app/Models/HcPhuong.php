<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HcPhuong extends HcBase
{
    use HasFactory;

    protected $table = 'pg_phuongxa';

    public function quan(): BelongsTo{
        return $this->belongsTo(HcQuan::class, 'ma_qh', 'ma');
    }

    public function tinh() {
        return $this->hasOneThrough(
            HcTinh::class,
            HcQuan::class,
            'ma_tp',
            'ma',
            'ma_tp',
            'ma_tp'
        );
    }
}
