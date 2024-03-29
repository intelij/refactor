<?php
return
    [
        'form' =>
            [
                /*
                 * The class or classes that you want to put on the submit button
                 * of the payment form
                 */
                'submitButtonClass' => 'test'
            ],

        'sagepay' =>
            [
                'clientSecret' => env('sagepay_CLIENT_SECRET'),
                'serverSecret' => env('sagepay_SERVER_SECRET'),

                /*
                 * MPI Account number
                 */
                'uid' => env('sagepay_UID'),

                /*
                 * The url to where the payment will take place
                 */
                'mpiUrl' => '',

                /*
                 * The name of the route where sagepay will redirect to
                 * after the payment has been made
                 *
                 */
                'paymentLandingPageRoute' => 'verifyPayment',

                /*
                 * Optional url of the css which must be applied on the payment form
                 */
                'formCss'=> '',

                /*
                 * Url of the template which will be applied on  sagepay pages
                 */
                'template'=> '',

                /*
                 * Optional title of the payment form
                 */
                'formTitle' => '',

                /*
                 * Optional e-mail address of the merchant
                 */
                'merchantEmail' => '',

                /*
                 * Optional e-mail address to use as sender for the second chance
                 * or payment link e-mail
                 */
                'secondChanceEmailSender' => '',
            ]
    ];
