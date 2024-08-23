<?php

namespace App\Http\Controllers\Backend\Feature;

use App\Http\Controllers\Controller;
use App\Models\Feature\Order;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = new CrudRepositories($order);
    }

    public function index($status = null)
    {
        if ($status == null) {
            $data['order'] = $this->order->get();
        } else {
            // $data['order'] = $this->order->Query()->where('status', $status)->get();
            $data['order'] = $this->order->Query()->where('status', $status)->orderBy('updated_at', 'DESC')->get();
        }
        return view('backend.feature.order.index', compact('data'));
    }

    public function show($id)
    {
        $data['order'] = Order::find($id);
        return view('backend.feature.order.show', compact('data'));
    }

    public function inputResi(Request $request)
    {
        $request->merge(['status' => 2]);
        $this->order->Query()->where('invoice_number', $request->invoice_number)->first()->update($request->only('status', 'receipt_number'));
        return back()->with('success', __('message.order_receipt'));
    }

    // Function show Report:
    public function transaction(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = Order::whereIn('status', [1, 2, 3]);

        if ($startDate && $endDate) {
            $orders->whereBetween('paid_at', [$startDate, $endDate]);
        } else {
            $currentMonth = date('Y-m');
            $orders->whereRaw("DATE_FORMAT(paid_at, '%Y-%m') = '$currentMonth'");
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');
        }

        $orders = $orders->get();

        $report = [];
        foreach ($orders as $order) {
            $date = date('Y-m-d', strtotime($order->paid_at));
            if (!isset($report[$date])) {
                $report[$date] = [
                    'date' => $date,
                    'total_sales' => 0,
                    'total_revenue' => 0,
                ];
            }
            $report[$date]['total_sales']++;
            $report[$date]['total_revenue'] += $order->total_pay;
        }

        ksort($report);

        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return view('backend.report.transaction', compact('report', 'data'));
    }
}
