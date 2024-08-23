<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecoltareSangeProdusPret extends Model
{
    use HasFactory;

    protected $table = 'recoltari_sange_produse_preturi';
    protected $guarded = [];

    public function path()
    {
        return "/recoltari-sange-produse-preturi/{$this->id}";
    }

    /**
     * Get the produs that owns the RecoltareSangeProdusPret
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produs(): BelongsTo
    {
        return $this->belongsTo(RecoltareSangeProdus::class, 'produs_id');
    }
}
