<?php

namespace App\Models;

use App\Http\Controllers\ProductController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use NumberFormatter;

class Order extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity'
    ];
    protected $appends = ['total_price'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function findByUuid(string $uuid)
    {

        $result = self::where('uuid', $uuid);

        if (!$result) {
            throw (new ModelNotFoundException)->setModel(get_called_class());
        }

        return $result;
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($date) => Carbon::make($date)->format('Y-m-d H:i:s'),
            set: fn($date) => $date
        );
    }

    /**
     * Get total price to an order, using product price and order quantity.
     */
    public function totalPrice(): Attribute
    {
        $price = isset($this->product) ? $this->product->getRawOriginal('price') : 0;
        $total = isset($this->quantity) ? $this->quantity * $price : 0;

        $formatter = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn($price) => $formatter->format(($total / 100))
        );
    }
}
