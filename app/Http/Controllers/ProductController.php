<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        return response()->json($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        if ($request->input('img_path') == (null || ''))
            $img_path = NULL;
        else
            $img_path = $request->input('img_path');

        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'img_path' => $img_path
            ]);

            return response($product, 201);
        } catch (\Exception $e) {
            return response('error creating the product: ' . $e, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Returns 404 if failed
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        //Returns 404 if failed
        $product = Product::findOrFail($id);
        //Only update the columns with values in the request
        $product->update($request->all());

        return response($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Returns 404 if failed
        $product = Product::findOrFail($id);
        $product->delete();

        return response('removed', 200);
    }

    public function addImage(Request $request, $id)
    {
        //Returns 404 if failed
        $product = Product::findOrFail($id);

        $product->update(['img_path' => $request->input('img_path')]);
        return response('success', 200);
    }
}
