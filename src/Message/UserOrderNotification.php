<?php

namespace App\Message;

use App\Document\Order;

final class UserOrderNotification
{
    private string $email;
    private Order $order;

    public function __construct(string $email, Order $order)
    {
        $this->email = $email;
        $this->order = $order;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
