<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardRequest;
use App\Order;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(DashboardRequest $request)
    {
        /** Date variables */
        $dateToday = date('Y-m-d');

        $nbDay = date('N', strtotime($dateToday));
        $monday = new DateTime($dateToday);
        $sunday = new DateTime($dateToday);
        $monday->modify('-' . ($nbDay - 1) . ' days');
        $sunday->modify('+' . (7 - $nbDay) . ' days');
        $mondayCurrentWeek =  date('Y-m-d', $monday->getTimestamp());
        $sundayCurrentWeek = date('Y-m-d', $sunday->getTimestamp());
        $monthStartDate = date("Y-m-01", strtotime("this month"));
        $monthEndDate = date("Y-m-t", strtotime("this month"));

        return response([
            'sales' => [
                'daily' => [
                    'sum' =>  Order::whereStatus('DELIVERED')->whereBetween('updated_at', [$dateToday . " 00:00:00", $dateToday . " 23:59:59"])->sum('grand_total'),
                    'count' => Order::whereStatus('DELIVERED')->whereBetween('updated_at', [$dateToday . " 00:00:00", $dateToday . " 23:59:59"])->count(),
                ],
                'weekly' => [
                    'sum' =>  Order::whereStatus('DELIVERED')->whereBetween('updated_at', [$mondayCurrentWeek . " 00:00:00", $sundayCurrentWeek . " 23:59:59"])->sum('grand_total'),
                    'count' => Order::whereStatus('DELIVERED')->whereBetween('updated_at', [$mondayCurrentWeek . " 00:00:00", $sundayCurrentWeek . " 23:59:59"])->count(),
                ],
                'monthly' => [
                    'sum' => Order::whereStatus('DELIVERED')->whereBetween('updated_at', [$monthStartDate . " 00:00:00", $monthEndDate . " 23:59:59"])->sum('grand_total'),
                    'count' => Order::whereStatus('DELIVERED')->whereBetween('updated_at', [$monthStartDate . " 00:00:00", $monthEndDate . " 23:59:59"])->count(),
                ],
                'overall' => [
                    'sum' => Order::whereStatus('DELIVERED')->sum('grand_total'),
                    'count' => Order::whereStatus('DELIVERED')->count()
                ]
            ],
            'orders' => [
                'total' => $total = Order::count(),
                'delivered' => $delivered = Order::whereStatus('DELIVERED')->count(),
                'cancelled' => $cancelled = Order::whereStatus('CANCELLED')->count(),
                'others' => $total - ($delivered + $cancelled)
            ],
        ]);
    }
}
