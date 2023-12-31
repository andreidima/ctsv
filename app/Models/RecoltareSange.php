<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoltareSange extends Model
{
    use HasFactory;

    protected $table = 'recoltari_sange';
    protected $guarded = [];

    public function path()
    {
        return "/recoltari-sange/{$this->id}";
    }

    /**
     * Get the grupa that owns the RecoltareSange
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupa()
    {
        return $this->belongsTo(RecoltareSangeGrupa::class, 'recoltari_sange_grupa_id');
    }

    /**
     * Get the produs that owns the RecoltareSange
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produs()
    {
        return $this->belongsTo(RecoltareSangeProdus::class, 'recoltari_sange_produs_id');
    }

    /**
     * Get the rebut that owns the RecoltareSange
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rebut()
    {
        return $this->belongsTo(RecoltareSangeRebut::class, 'recoltari_sange_rebut_id');
    }

    /**
     * Get the comanda that owns the RecoltareSange
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comanda()
    {
        return $this->belongsTo(RecoltareSangeComanda::class, 'comanda_id');
    }

    /**
     * Get the comanda that owns the RecoltareSange
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function intrare()
    {
        return $this->belongsTo(RecoltareSangeIntrare::class, 'intrare_id');
    }
}
