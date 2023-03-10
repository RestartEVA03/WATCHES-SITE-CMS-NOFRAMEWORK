<?php

use watchesshop\Router;

Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controllers' => 'Product', 'action' => 'view']);
Router::add('^category/(?P<alias>[a-z0-9-]+)/?$', ['controllers' => 'Category', 'action' => 'view']);

// default routes
Router::add('^admin$', ['controllers' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controllers>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

Router::add('^$', ['controllers' => 'Main', 'action' => 'index']);
Router::add('^(?P<controllers>[a-z-]+)/?(?P<action>[a-z-]+)?$');