<?php
namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $order;

    // Constructor will receive the order object
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // The channel the event will be broadcasted on
    public function broadcastOn()
    {
        return new Channel('orders');
    }

    // The data that will be broadcasted
    public function broadcastWith()
    {
        return [
            'OrderID' => $this->order->id,
            'Name' => $this->order->name,
            'Quantity' => $this->order->quantity,
            'OrderStatus' => $this->order->status, // Assuming 'status' is a field
        ];
    }
}
