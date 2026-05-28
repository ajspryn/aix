<?php

return [
     'serverKey' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA'),
     'clientKey' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-61XuGAwQ8Bj8LxSS'),
     'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),
     'isSanitized' => env('MIDTRANS_IS_SANITIZED', true),
     'is3ds' => env('MIDTRANS_IS_3DS', true),
];
