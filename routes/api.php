<?php

use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("install_shop", function () {
    $shopUrl = "my-laravel-store.myshopify.com";
    $scope = ["write_products", "read_orders"];
    $redirectUrl = "http://127.0.0.1:8000/api/process_oauth_result";
    // $redirectUrl = "http://mydomain.com/process_oauth_result";

    $shopify = Shopify::setShopUrl($shopUrl);
    return redirect()->to($shopify->getAuthorizeUrl($scope, $redirectUrl));
});

Route::get("process_oauth_result", function (\Illuminate\Http\Request $request) {
    $shopUrl = "my-laravel-store.myshopify.com";
    $accessToken = Shopify::setShopUrl($shopUrl)->getAccessToken($request->code);

    return response($accessToken, 200);

    // redirect to success page or billing etc.
});

Route::get('getProducts', 'ShopifyController@getProducts');

Route::post('postProduct', 'ShopifyController@postProduct');

Route::post('editProduct', 'ShopifyController@editProduct');

Route::delete('deleteProduct/{id}', 'ShopifyController@deleteProduct');
