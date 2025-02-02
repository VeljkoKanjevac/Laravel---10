<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function saveProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:products',
            'description' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:0',
            'image' => 'required|string'
        ]);

        ProductsModel::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'amount' => $request->get('amount'),
            'image' => $request->get('image')
        ]);

        return redirect()->route('allProducts');
    }

    public function getAllProducts()
    {
        $allProducts = ProductsModel::all();

        return view('allProducts', compact('allProducts'));
    }

    public function deleteProduct($product)
    {
        $singleProduct = ProductsModel::where(['id' => $product])->first();

        if($singleProduct === null)
        {
            die("Ovaj proizvod ne postoji");
        }

        $singleProduct->delete();

        return redirect()->back();
    }

    public function getProductById(ProductsModel $product)
    {
        return view('updateProduct', compact('product'));
    }

    public function updateProduct(Request $request,ProductsModel $product)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:products',
            'description' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:0',
            'image' => 'required|string'
        ]);

        $product->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'amount' => $request->get('amount'),
            'image' => $request->get('image')
        ]);

        return redirect()->route('allProducts');
    }
}
