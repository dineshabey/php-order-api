<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $processId;

    public function __construct(Order $order, $processId)
    {
        $this->order = $order;
        $this->processId = $processId;
    }

    public function handle()
    {
        $response = Http::post('https://wibip.free.beeceptor.com/order', [
            'Order_ID' => $this->order->id,
            'Customer_Name' => $this->order->customer_name,
            'Order_Value' => $this->order->order_value,
            'Order_Date' => $this->order->created_at->toDateTimeString(),
            'Order_Status' => $this->order->order_status,
            'Process_ID' => $this->processId,
        ]);

        if ($response->successful()) {
            $this->order->update(['order_status' => 'Processed']);
            Log::info('Order processed successfully: ' . $this->order->id);
        } else {
            $this->order->update(['order_status' => 'Failed']);
            Log::error('Order processing failed: ' . $this->order->id);
        }
    }
}
