<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class RecoltareSangeProdus extends Model
{
    use HasFactory;

    protected $table = 'recoltari_sange_produse';
    protected $guarded = [];

    public function path()
    {
        return "/recoltari-sange-produse/{$this->id}";
    }

    /**
     * Get all of the preturi for the RecoltareSangeProdus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preturi(): HasMany
    {
        return $this->hasMany(RecoltareSangeProdusPret::class, 'produs_id');
    }
}
