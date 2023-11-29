<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'document',
        'email'
    ];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
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
