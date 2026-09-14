<?php

return [
    'owner_email' => env('SHOP_OWNER_EMAIL', 'admin@radiatoroutlet.hu'),
    'phone' => env('SHOP_PHONE', '06204662774'),
    'phone_display' => env('SHOP_PHONE_DISPLAY', '06 20 466 2774'),
    'shipping_fee' => (int) env('SHOP_SHIPPING_FEE', 2500),
    'pickup_address' => env('SHOP_PICKUP_ADDRESS', 'Budapest XXIII. kerület, Soroksár'),
    'admin_email' => env('ADMIN_EMAIL', 'admin@radiatoroutlet.hu'),
    'admin_password' => env('ADMIN_PASSWORD', 'Admin123!'),
];
