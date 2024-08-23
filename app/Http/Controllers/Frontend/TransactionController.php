<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Feature\Order;
use App\Repositories\CrudRepositories;
use App\Services\Feature\OrderService;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $orderService;
    protected $order;
    public function __construct(OrderService $orderService, Order $order)
    {
        $this->orderService = $orderService;
        $this->order = new CrudRepositories($order);
    }

    public function index()
    {
        $data['orders'] = $this->orderService->getUserOrder(auth()->user()->id);
        return view('frontend.transaction.index', compact('data'));
    }

    public function show($invoice_number)
    {
        $data['order'] = $this->order->Query()->where('invoice_number', $invoice_number)->first();
        $snapToken = $data['order']->snap_token;
        if (empty($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database
            $midtrans = new CreateSnapTokenService($data['order']);
            $snapToken = $midtrans->getSnapToken();
            $data['order']->snap_token = $snapToken;
            $data['order']->save();
        }
        return view('frontend.transaction.show', compact('data'));
    }

    public function received($invoice_number)
    {
        $this->order
            ->Query()
            ->where('invoice_number', $invoice_number)
            ->first()
            ->update(['status' => 3]);
        return back()->with('success', __('message.order_received'));
    }

    public function canceled($invoice_number)
    {
        $this->order
            ->Query()
            ->where('invoice_number', $invoice_number)
            ->first()
            ->update(['status' => 4]);
        return back()->with('success', __('message.order_canceled'));
    }
    public function update_transaction(Request $request)
    {
        // Retrieve values from URL parameters
        $order_id = $request->query('order_id');
        $status_code = $request->query('status_code');
        $transaction_status = $request->query('transaction_status');

        // Display the values for debugging
        var_dump($request->query());

        if ($transaction_status == 'settlement') {
            $order = $this->order->Query()
                ->where('invoice_number', $order_id)
                ->first();
            if ($order) {
                $order->update([
                    'status' => 1,
                    'paid_at' => date('Y-m-d h:i:s')
                ]);
                return back()->with('success', __('message.order_success'));
            } else {
                return back()->with('error', __('message.order_not_found'));
            }
        } else if ($transaction_status == 'expire') {
            $this->order
                ->Query()
                ->where('invoice_number', $order_id)
                ->first()
                ->update(['status' => 5]);
            return back()->with('success', __('message.order_canceled'));
        }

        // Check if all required parameters are present
        if ($order_id && $status_code && $transaction_status) {
            // Proceed with your logic
            echo 'Order ID: ' . $order_id . '<br>';
            echo 'Status Code: ' . $status_code . '<br>';
            echo 'Transaction Status: ' . $transaction_status . '<br>';
        } else {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }
    }
}
