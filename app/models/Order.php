<?php

namespace app\models;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use watchesshop\App;

class Order extends AppModel
{
    public static function saveOrder($data){
        $order = \R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = \R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }

    public static function saveOrderProduct($order_id){
        $sql_part = '';
        foreach ($_SESSION['cart'] as $product_id => $product){
            $product_id = (int)$product_id;
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
        }
        $sql_part = rtrim($sql_part, ',');
        \R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
    }

    public static function mailOrder($order_id, $user_email){
        $MAILER_DSN='smtp://'. App::$app->getProperty('smtp_login')
                            .':' . App::$app->getProperty('smtp_password')
                            . '@smtp.mail.ru:'
                            . 465;
        $transport = Transport::fromDsn($MAILER_DSN);
        $mailer = new Mailer($transport);
        ob_start();
        require APP . "/views/mail/mail_order.php";
        $body = ob_get_clean();

        $email = (new Email())
            ->from(App::$app->getProperty('smtp_login'))
            ->to($user_email)
            ->subject('Ваш заказ на сайте Watchesshop')
            ->html($body);

        //$result = $mailer->send($email);
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $_SESSION['success'] = 'Спасибо за Ваш заказ.';
    }

}