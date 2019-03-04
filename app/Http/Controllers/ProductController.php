<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;

use Validator;

class ProductController extends Controller
{
    private $res = array();
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['msg'] = '';
        $this->res['status'] = false;

        date_default_timezone_set('America/Mexico_City');
    }//__construct()

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index', ['request' => $this->request]);
    }

    
    public function ListInterface()
    {
        try{
            $products = [];

            $products = Product::all();

            if(count($products) > 0){

                foreach ($products as $kp => $vp){
                    $vp->selected = false;
                    $vp->quantity = 1;
                    $vp->total = $vp->price;
                }

                $this->res['status'] = true;
                $this->res['data'] = $products;
            } else {
                $this->res['msg'] = 'No hay productos registrados hasta el momento.';
            }
        } catch(\Exception $e){
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//

    public function lists()
    {
        try{
            $this->ListInterface();
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//lists()
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = [];

            $validator = Validator::make($this->request->all(), [
                'name'      => 'required|max:255',
                'price'     => 'required|max:22'
            ]);

            $id             = $this->request->input('id');
            $data['name']   = $this->request->input('name');
            $data['price']  = $this->request->input('price');
            $data['stock']  = $this->request->input('stock');

            if (!$validator->fails()) {

                if($id == null){
                    $dup = Product::where('name', $data['name'])->count();

                    if($dup == 0){
                        $product = new Product;
                        $product->name = $data['name'];
                        $product->price = $data['price'];
                        $product->stock = $data['stock'];
                        $product->save();
        
                        $this->res['msg'] = 'Producto guardado correctamente.';
                        $this->res['status'] = true;
                    } else {
                        $this->res['msg'] = 'El nombre del producto ya existe.';
                    }
                } else {
                    $product = Product::find($id);

                    if($product){
                        $dup = Product::where('name', $data['name'])
                                        ->where('id', '!=', $product->id)
                                        ->count();
                        if($dup == 0){
                            $product->name = $data['name'];
                            $product->price = $data['price'];
                            $product->stock = $data['stock'];
                            $product->save();

                            $this->res['msg'] = 'Producto actualizado correctamente.';
                            $this->res['status'] = true;
                        } else {
                            $this->res['msg'] = 'El nombre del producto ya existe.';
                        }
                    } else {
                        $this->res['msg'] = 'El producto seleccionado no existe.';
                    }
                }
            } else {
                $this->res['msg'] = 'Todos los campos son requeridos.';
            }
        } catch (\Excpetion $e){
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }

    public function CheckStock()
    {
        try {
            $product_id = $this->request->input('product_id');
            $quantity = $this->request->input('quantity');

            $product = Product::find($product_id);

            if($product){
                if($product->stock >= $quantity){
                    $this->res['status'] = true;
                } else {
                    $this->res['msg'] = 'No hay stock suficiente para poder agregar este producto.';
                }
            } else {
                $this->res['msg'] = 'El producto no existe.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//CheckStock()

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = Product::find($id);

            $product->delete();

            $this->res['msg'] = 'Producto eliminado correctamente.';
            $this->res['status'] = true;
        } catch (\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }
}
