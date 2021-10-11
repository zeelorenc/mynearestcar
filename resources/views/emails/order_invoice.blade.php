
Hi, {{ $order->user->name }}.

We've received your first payment. Thank you!

Total cost of ${{ number_format($order->grand_total + $order->security_deposit, 2) }} has been received.
Please find the order summary below:

- Rental cost: ${{ $order->total }}
- Uber cost: ${{ optional($order->uber)->total ?? 0 }}
- Security deposit: ${{ $order->security_deposit }}
