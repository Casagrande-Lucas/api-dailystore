<?php

namespace App\Http\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductApi
{
    public function list(): JsonResponse
    {
        return response()->json(['success' => true, 'message' => 'List Products', 'data' => (new Product())->all()], options: JSON_UNESCAPED_UNICODE);
    }
}
