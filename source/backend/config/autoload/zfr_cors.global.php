<?php

/**
 * This is the config file for ZfrCors. Just drop this file into your config/autoload folder (don't
 * forget to remove the .dist extension from the file), and configure it as you want
 */

return [
    'zfr_cors' => [
          'allowed_origins' => ['*'],
          'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],

          'allowed_headers' => [
              'Authorization',
              'Content-Type',
          ],

         /**
          * Set the list of exposed headers. This is a whitelist that authorize the browser
          * to access to some headers using the getResponseHeader() JavaScript method. Please
          * note that this feature is buggy and some browsers do not implement it correctly
          */
         // 'exposed_headers' => [],

         /**
          * Standard CORS requests do not send or set any cookies by default. For this to work,
          * the client must set the XMLHttpRequest's "withCredentials" property to "true". For
          * this to work, you must set this option to true so that the server can serve
          * the proper response header.
          */
          'allowed_credentials' => true,
    ],
];
