<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ProductController extends Controller
{
    private int $pageLength = 50;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::where('active', true)->orderBy('name')->paginate($this->pageLength);

        return view('products/index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('product/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'min:0',
            'value' => 'min:0.00',
        ]);

        try {
            (new Product($request->all()))->saveOrFail();
        } catch (\Throwable $e) {
            return redirect('product/create')->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect('product/create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Redirector|View
    {
        return view('products/edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|min:0',
            'value' => 'required|min:0.00',
        ]);

        try {
            $product->updateOrFail($request->all());
        } catch (\Throwable $e) {
            return redirect("products/{$product->id}/edit")->withErrors('error', 'Erro ao editar o produto: ' . $e->getMessage())->withInput();
        }

        return redirect("products/{$product->id}/edit")->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $product->active = false;
            $product->saveOrFail();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'errors' => ['generic' => $e->getMessage()]], 500);
        }

        return response()->json(['success' => true, 'reload' => true]);
    }

    public function fastSetAmount(Request $request): JsonResponse
    {
        $request->validate([
            'isIncrement' => 'required',
            'productId' => 'required|exists:products,id',
        ]);

        try {
            $product = Product::findOrFail($request->input('productId'));
        } catch (\Throwable $e) {
            return response()->json(['error' => 'internal server error: ' . $e->getMessage()], 500);
        }

        $isIncrement = $request->input('isIncrement');

        if ($isIncrement === "true") {
            $product->amount++;
        } else {
            $product->amount--;
        }

        try {
            $product->saveOrFail();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'internal server error: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'amount' => $product->amount,
            'total' => number_format(($product->amount * $product->value), 2, ',', '.')
        ]);
    }
}
