<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;


class ShopifyController extends Controller
{

    public function __construct(Request $request)
    {
        $this->shopUrl = "my-laravel-store.myshopify.com";
        $this->accessToken = "18a4af1b20f3dcafe25b9db4ab57c90e";
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
        // $product = ["product" => $request->all()];
        // $product =  $request->all();

        // return ($product);

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
        // $product = ["product" => $request->all()];
        // return ($product);
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
        // return ($request->id);
        $products = Shopify::setShopUrl($this->shopUrl)->setAccessToken($this->accessToken)->delete(
            "admin/products/{$request->id}.json"
        );

        return response($products, 201);
    }
}
