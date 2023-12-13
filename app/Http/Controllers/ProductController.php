<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    private int $pageLength = 100;
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
        return view('products/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'size' => 'required|string|nullable',
            'color' => 'required|string|nullable',
            'amount' => 'required|min:0',
            'value' => 'required|min:0.00',
        ]);

        $data = $request->all();

        $data['id'] = Str::orderedUuid();
        $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));

        try {
            (new Product($data))->saveOrFail();
        } catch (\Throwable $e) {
            return redirect('products/create')->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect('products/create')->withErrors(['success' => 'Produto criado!']);
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
    public function edit(Product $product): View
    {
        return view('products/edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'string|nullable',
            'size' => 'string|nullable',
            'color' => 'string|nullable',
            'amount' => 'min:0|nullable',
            'value' => 'min:0.00|nullable',
        ]);

        $data = $request->all();

        if (!empty($data['value'])) {
            $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));
        }

        try {
            $product->updateOrFail($data);
        } catch (\Throwable) {
            return redirect("products/{$product->id}/edit")->withErrors(['error' => 'Erro ao atualizar o produto!'])->withInput();
        }

        return redirect("products/$product->id/edit")->withErrors(['success' => 'Produto atualizado com sucesso!'])->withInput();
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
