<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ratchet Websocket Library: config file
 * @author Romain GALLIEN <romaingallien.rg@gmail.com>
 * @var array
 */
$config['ratchet_websocket'] = array(
    'host' => '192.168.1.2',    // Default host
    'port' => 8282,         // Default port (be carrefull to set unused server port)
    'auth' => false,         // If authentication is mandatory
    'debug' => true         // Better to set as false in Production
);
