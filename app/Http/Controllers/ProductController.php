<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use App\Traits\RequestService;
use function config;

class ProductController extends Controller
{
    use RequestService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $baseUri;
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('service.commonApigateway.base_uri');
        $this->secret = config('service.commonApigateway.secret');
    }

    public function index(){
        $products = Product::all();

        return $this->successResponse($products);
    }

    public function show($product){
        $product_get = Product::find($product);

        return $this->successResponse($product_get);
    }

    public function store(Request $request){
        $p_name = $request->name;
        
        // make function in API gateway and call here
        $name = $this->updateName($p_name);
        
        $request['name'] = $name;

        $product = Product::create($request->all());

        return $this->successResponse($product);
    }

    public function update(Request $request){
        $all_data = $request->all();

        $product = Product::findOrFail($all_data['id']);
        $product = $product->fill($all_data);

        $product->save();

        return redirect()->to('api/product');

    }

    public function destroy($id){

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->to('api/product');
    }

    public function updateName($name){
        return $this->request('GET', '/api/product/updateName/'.$name);
    }
}
