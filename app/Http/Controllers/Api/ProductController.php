<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
{
    try {
        $barcode = $request->get('barcode');
        
        $product = Product::where('barcode', $barcode)
                        ->where('status', 1)
                        ->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 200); 
        }
        
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'barcode' => $product->barcode,
                'quantity' => 1
            ]
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mencari produk'
        ], 500);
    }
}
}