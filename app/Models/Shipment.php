<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'sender_name',
        'sender_address',
        'receiver_name',
        'receiver_address',
        'package_weight',
        'status',
    ];
}
