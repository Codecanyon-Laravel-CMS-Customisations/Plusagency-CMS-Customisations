<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Link when product is available only offline
    |--------------------------------------------------------------------------
    |
    | This value is the the base url to digital website for restricted products
    | which need admin verification first for product to be accessed.
    |
    */

  'locked_product_link' => env('DIGITAL_LOCKED_PRODUCT_LINK', 'https://digital.angelbookhouse.com'),
];
