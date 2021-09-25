<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class OrderExportController extends Controller
{
    public function export()
    {
        /** @var Collection $orders */
        $orders = auth()->user()->orders;
        if ($orders->isEmpty()) {
            return response('Not Found', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $orders = $orders
            ->sortBy('created_at')
            ->map(function ($order) {
                return [
                    'Vehicle' => $order->vehicle->name,
                    'From Date' => $order->from_date->toDateTimeString(),
                    'To Date' => $order->to_date->toDateTimeString(),
                    'Uber Total' => optional($order->uber)->total ?? 0.0,
                    'Grand Total' => $order->grand_total,
                    'Status' => ucfirst($order->status),
                    'Created At' => $order->created_at->toDateTimeString(),
                    'Updated At' => $order->updated_at->toDateTimeString(),
                ];
            });
        $callback = function () use ($orders) {
            $out = fopen('php://output', 'w');
            fputcsv($out, array_keys($orders[0]));
            $orders->each(function (array $order) use ($out) {
                fputcsv($out, $order);
            });
            fclose($out);
        };
        return response()->stream($callback, 200, [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=orders-' . date('Y-m-d-His') . '.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ]);
    }
}
