<?php

//Guest Routes===============================================
$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@Login');
$router->get('/register', 'AuthController@registerPage');
$router->get('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@Logout');


//User Routes===============================================
$router->get('/home', 'userCatalogController@index');
$router->get('/cart', 'userCartController@index');
$router->get('/cart/add', 'userCartController@add');
$router->get('/cart/remove', 'userCartController@remove');
$router->get('/checkout', 'userCartController@index');
$router->get('/checkout', 'userCartController@store');
$router->get('/orders', 'userController@index');


// ==========================================
$router->get('/admin', 'adminController@index');



//Products
$router->get('/admin/products', 'adminController@index');
$router->get('/admin/products/create', 'adminController@create');
$router->post('/admin/products/store', 'adminController@store');
$router->get('/admin/products/edit', 'adminController@edit');
$router->post('/admin/products/update', 'adminController@update');
$router->post('/admin/products/delete', 'adminController@delete');


//Categories
$router->get('/admin/categories', 'categoriesController@index');
$router->get('/admin/categories/create', 'categoriesController@create');
$router->get('/admin/categories/store', 'categoriesController@store');
$router->get('/admin/categories/edit', 'categoriesController@edit');
$router->get('/admin/controller/delete', 'categoriesController@delete');

//Orders
$router->get('/admin/orders', 'ordersController@index');
$router->get('/admin/orders/create', 'ordersController@create');
$router->post('/admin/orders/store', 'ordersController@store');
$router->get('/admin/orders/edit', 'ordersController@edit');
$router->post('/admin/orders/update', 'ordersController@update');
$router->post('/admin/orders/delete', 'ordersController@delete');




?>