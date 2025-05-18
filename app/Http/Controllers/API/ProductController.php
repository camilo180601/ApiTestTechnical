<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a paginated list of products with their categories.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function index()
    {
        return Product::with('category')->paginate(10);
    }

    /**
     * Retrieve a product by its ID, with its category.
     *
     * @param  int  $id
     * @return \App\Models\Product
     */
    public function show($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Product
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        return Product::create($validated);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Models\Product
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin($request);

        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|integer',
        ]);

        $product->update($validated);
        return $product;
    }

    /**
     * Remove the specified product from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        Product::destroy($id);
        return response()->json(['message' => 'Product deleted']);
    }

    /**
     * Checks if the user has the admin role and aborts with a 403
     * if not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function authorizeAdmin(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }
}
