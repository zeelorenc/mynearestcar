
Hi, {{ $order->user->name }}.

We've received your first payment. Thank you!

Total cost of ${{ number_format($order->total + $order->uber->getTotalAttribute(), 2) }} has been received.
Please find the order summary below:

- Rental cost: ${{ $order->total }}
- Uber cost: ${{ $order->uber->getTotalAttribute() }}
