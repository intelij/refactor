<?php

namespace DivideBuy\Payment;

use Illuminate\Support\ServiceProvider;
use DivideBuy\Payment\Gateways\Sagepay\PaymentGateway as SagepayPaymentGateway;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/payment.php', 'payment');

        $this->publishes(
            [
                __DIR__.'/../config/payment.php' => base_path('config/payment.php')
            ],
            'config'
        );
    }

    public function register()
    {
        $this->app->bind(PaymentGateway::class, SagepayPaymentGateway::class);
    }

}
