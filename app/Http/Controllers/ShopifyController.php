<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;


class ShopifyController extends Controller
{

    public function __construct(Request $request)
    {
        $this->shopUrl = "my-laravel-store.myshopify.com";
        $this->accessToken = config("shopify.access_token");
    }

    public function getProducts(Request $request)
    {
        $products = Shopify::setShopUrl($this->shopUrl)
            ->setAccessToken($this->accessToken)
            ->get("admin/products.json");

        return response($products, 200);
    }

    public function postProduct(Request $request)
    {
        $products = Shopify::setShopUrl($this->shopUrl)
            ->setAccessToken($this->accessToken)
            ->post(
                "admin/products.json",
                [
                    "product" => $request->all()
                ]
            );

        return response($products, 200);
    }

    public function editProduct(Request $request)
    {
        $products = Shopify::setShopUrl($this->shopUrl)
            ->setAccessToken($this->accessToken)
            ->put(
                "admin/products/{$request->id}.json",
                [
                    "product" => $request->all()
                ]
            );

        return response($products, 201);
    }

    public function deleteProduct(Request $request)
    {
        $products = Shopify::setShopUrl($this->shopUrl)
            ->setAccessToken($this->accessToken)
            ->delete(
                "admin/products/{$request->id}.json"
            );

        return response("Product deleted successfully", 201);
    }

    public function webhook(Request $request)
    {
        if ($request->header('X-Shopify-Hmac-Sha256')) {
            $hmac_header = $request->header('X-Shopify-Hmac-Sha256');
            $data = file_get_contents('php://input');
            $calculated_hmac = base64_encode(hash_hmac('sha256', $data, env('WEBHOOK_CLIENT_SECRET'), true));

            logger('webhook came through');

            if ($hmac_header != $calculated_hmac) {

                logger("invalid webhook secret");

            } else{ 

                logger($request->header('x-shopify-topic')." successful");

            }
        }
             else {
                
                logger("no webhook secret");
            }
        
    }
}
