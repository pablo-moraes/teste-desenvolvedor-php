<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use NumberFormatter;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'bar_code',
        'name',
        'price'
    ];

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function price(): Attribute
    {
        $formatter = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn($price) => $formatter->format(($price / 100)),
            set: fn($price) => preg_replace('/[^0-9]+/', '', $price)
        );
    }

    public static function findByUuid(string $uuid)
    {

        $result = self::where('uuid', $uuid);

        if (!$result) {
            throw (new ModelNotFoundException)->setModel(get_called_class());
        }

        return $result;
    }

}
