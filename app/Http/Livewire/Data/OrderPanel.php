<?php

namespace App\Http\Livewire\Data;

use App\Models\Data\Link;
use App\Models\Data\Order;
use App\Models\Generic\Block;
use Livewire\Component;

class OrderPanel extends Component
{
    public $orderId;
    public $blockId;

    public function render()
    {
        $order = Order::find($this->orderId);

        $blocks = array();
        foreach($order->mapping->blocks as $block) {
            if(isset($block->type)) {
                $blocks[] = (object) $block;
            } else {
                $b = Block::find($block->id);
                $b->prev = $block->prev;
                $b->next = $block->next;
                $blocks[] = $b;
            }
        }

        $orderTrace = Link::where('orders', 'like', "%$this->orderId%")->first();

        $orders = array();
        if($orderTrace != null) {
            foreach($orderTrace->orders as $o) {
                $orders[] = Order::find($o);
            }
        }

        return view('livewire.data.order-panel', compact('order', 'blocks', 'orders'));
    }
}
