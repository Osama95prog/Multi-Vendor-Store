<?php

return [
  [
    'icon' => 'nav-icon fas fa-tachometer-alt',
    'title' => 'Dashboard',
    'route' => 'dashboard',
    'active' => 'dashboard',
    'badge' => 'new',
],
[
    'icon' => 'far fa-circle nav-icon',
    'title' => 'Categories',
    'route' => 'dashboard.categories.index',
    'active' => 'dashboard.categories.*',
    'badge' => '',
],
[
    'icon' => 'far fa-circle nav-icon',
    'title' => 'Products',
    'route' => 'dashboard.products.index',
    'active' => 'dashboard.products.*',
    'badge' => '',
],
[
    'icon' => 'far fa-circle nav-icon',
    'title' => 'Orders',
    'route' => 'dashboard.products.index',
    'active' => 'dashboard.orders.*',
    'badge' => '',
  ],
];
