<?php

namespace App\MessageHandler;

use App\Message\UserOrderNotification;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class UserOrderNotificationHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    #[Required]
    public function setMailer(MailerInterface $mailer): void
    {
        $this->mailer = $mailer;
    }

    public function __invoke(UserOrderNotification $message)
    {
        $userEmail = $message->getEmail();
        $order = $message->getOrder();
        $template = $this->toHtml($order);

        $email = (new Email())
            ->from('johanleonardois@ufps.edu.co',)
            ->to($userEmail)
            ->subject('User Order')
            ->html($template);
        $this->mailer->send($email);
    }

    private function showProductDetails($order): array
    {
        $products = [];
        for ($i = 0; $i < sizeof($order->getOrderDetails()); $i++) {
            $orderDetail = $order->getOrderDetails()[$i];
            $product = $orderDetail->getProduct();
            $name = $product->getName();
            $unitPrice = $product->getUnitPrice();
            $quantity = $orderDetail->getQuantity();
            $products[] = [$name, $unitPrice, $quantity];
        }
        return $products;
    }

    private function toHtml($order): string
    {
        $products = '';
        $productDetails = $this->showProductDetails($order);

        foreach ($productDetails as $product) {
            $products .=
                "<tr>
                    <td>$product[0]</td><td>$product[1]</td><td>$product[2]</td>
                </tr>";
        }
        $user = $order->getOwner()->getName();
        $total = $order->getTotal();
        return "
                <h1>Compra realizada con exito</h1><hr>
                <h2>Detalles</h2>
                <p>Usuario: $user</p>
                <table>
                    <thead>
                        <tr>
                            <th>
                                Producto
                            </th>
                            <th>
                                Cantidad
                            </th>
                            <th>
                                Precio Unitario
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        $products
                    </tbody>
                </table>
                <h3>Total: $total</h3>
        ";
    }
}
