<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    protected $primaryKey = 'complaint_id'; // ✅ sebab kau guna complaint_id
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'seller_id',
        'order_id',
        'handled_by',
        'complaint_message',
        //'admin_response',
        'status',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ComplaintMessage::class, 'complaint_id', 'complaint_id');
    }
}
