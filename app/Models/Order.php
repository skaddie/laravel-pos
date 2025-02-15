<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerName()
    {
        if($this->customer) {
            return $this->customer->first_name . ' ' . $this->customer->last_name;
        }
        return 'Walking Customer';
    }

    public function total()
    {
        return $this->items->map(function ($i){
            return $i->price;
        })->sum();
    }
    public function cost()
    {
        return $this->items->map(function ($i){
            return $i->cost;
        })->sum();
    }
    public function formattedTotal()
    {
        return number_format($this->total(), 2);
    }
    public function formattedCost()
    {
        return number_format($this->cost(), 2);
    }
    public function receivedAmount()
    {
        return $this->payments->map(function ($i){
            return $i->amount;
        })->sum();
    }

    public function formattedReceivedAmount()
    {
        return number_format($this->receivedAmount(), 2);
    }


    public function Income()
    {
        return $this -> $orders->map(function($i) {
            if($i->receivedAmount() > $i->total()) {
                return $i->total();
            }
            return $i->receivedAmount();
        })->sum();
    }
    public function formattedIncome()
    {
        return number_format($this->Income(), 2);
    }

}
