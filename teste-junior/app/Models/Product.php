<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'bar_code',
        'name',
        'price'
    ];

    protected $primaryKey = 'uuid';

    public function price(): Attribute
    {
        $formatter = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn($price) => $formatter->format(($price / 100)),
            set: fn($price) => preg_replace('/[^0-9]+/', '', $price)
        );
    }

}
