<?php

namespace App\Observers;

use App\Order;
use App\User;
use Illuminate\Support\Facades\Notification;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        // New Order - Administrator
        $administrators = User::whereRole('ADMINISTRATOR')->get();
        Notification::send($administrators, new \App\Notifications\NewOrder($order));
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $modelChanges = $order->getChanges();

        if (isset($modelChanges['status'])) {

            if ($modelChanges['status'] == 'CANCELLED') {
                // Cancelled - Administrator
                $administrators = User::whereRole('ADMINISTRATOR')->get();
                Notification::send($administrators, new \App\Notifications\OrderCancelled($order));
            } else if ($modelChanges['status'] == 'DECLINED') {
                // Declined - Customer
                $customerUser = $order->customer->user;
                Notification::send([$customerUser], new \App\Notifications\OrderDeclined($order));
            } else if ($modelChanges['status'] == 'ON-THE-WAY') {
                // OnTheWay - Customer
                $customerUser = $order->customer->user;
                Notification::send([$customerUser], new \App\Notifications\OrderOnTheWay($order));
            } else if ($modelChanges['status'] == 'DELIVERED') {
                // Delivered - Customer
                $customerUser = $order->customer->user;
                Notification::send([$customerUser], new \App\Notifications\OrderDelivered($order));
            }
        }
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
