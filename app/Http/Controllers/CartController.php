<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(
                $request->user()->cart()->get()
            );
        }
        return view('cart.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|exists:products,barcode',
        ]);
        $barcode = $request->barcode;

        $product = Product::where('barcode', $barcode)->first();
        $cart = $request->user()->cart()->where('barcode', $barcode)->first();
        if ($cart) {
            // check product quantity
            if ($product->quantity <= $cart->pivot->quantity) {
                return response([
                    'message' => __('cart.available', ['quantity' => $product->quantity]),
                ], 400);
            }
            // update only quantity
            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();
        } else {
            if ($product->quantity < 1) {
                return response([
                    'message' => __('cart.outstock'),
                ], 400);
            }
            $request->user()->cart()->attach($product->id, ['quantity' => 1]);
        }

        return response('', 204);
    }

    public function changeQty(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $cart = $request->user()->cart()->where('id', $request->product_id)->first();

        if ($cart) {
            // check product quantity
            if ($product->quantity < $request->quantity) {
                return response([
                    'message' => __('cart.available', ['quantity' => $product->quantity]),
                ], 400);
            }
            $cart->pivot->quantity = $request->quantity;
            $cart->pivot->save();
        }

        return response([
            'success' => true
        ]);
    }

    public function remove(Request $request)
{
    try {
        $productId = $request->input('product_id');

        // Misal kamu simpan keranjang di session:
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        // Hitung ulang total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cart' => [
                'items' => array_values($cart),
                'total' => $total
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menghapus item.'
        ], 500);
    }
}
    public function empty(Request $request)
    {
        $request->user()->cart()->detach();

        return response('', 204);
    }

    public function checkout(Request $request)
{
    try {
        $cart = session('cart');

        if (!$cart || empty($cart['items'])) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 400);
        }

        // VALIDASI CUSTOMER
        if (!$request->customer_name) {
            return response()->json([
                'success' => false,
                'message' => 'Nama customer wajib diisi'
            ], 422);
        }

        // BUAT ORDER
        $order = \App\Models\Order::create([
            'customer_name' => $request->customer_name,
            'total' => $cart['total'],
            'status' => 'completed'
        ]);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat order'
            ], 500);
        }

        // SIMPAN ITEM
        foreach ($cart['items'] as $item) {

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity']
            ]);

            // UPDATE STOK
            \App\Models\Product::where('id', $item['id'])
                ->decrement('quantity', $item['quantity']);
        }

        // HAPUS CART
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil disimpan',
            'redirect_url' => route('orders.index')
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Checkout error: ' . $e->getMessage()
        ], 500);
    }
}

}
