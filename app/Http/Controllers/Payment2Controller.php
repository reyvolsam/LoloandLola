<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UsersSlots;
use App\Payment;
use App\Product;
use App\ServicePayment;
use App\ProductPayment;

class Payment2Controller extends Controller
{
    
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
        return view('payment.index', ['request' => $this->request]);
    }

    public function lists()
    {
        return view('payment.list', ['request' => $this->request]);
    }

    public function GetPaymentList()
    {
        try {
            $page = $this->request->input('page');
            $date = $this->request->input('date');
            
            $payment_list = [];
            $grand_total_payment = 0;

            $msg = 'No hay pagos registrados hasta el momento.';
            $rowsPerPage = 2;
            $offset = 0;
            $total_pages = 1;
            $total = 0;

            $offset = ($page - 1) * $rowsPerPage;

            $total = Payment::query()->count();

            $payment_list = Payment::with(['service_payment' => 
                                        function ($query){
                                            $query->with('service');
                                        }, 
                                        'product_payment' =>
                                        function ($query){
                                            $query->with('product');
                                        }, 'user_slot', 'discount', 'payment_type'])->orderBy('created_at', 'DESC');

            if(isset($date)){
                $init_date = $date." 00:00:00";
                $final_date = date("Y-m-d",strtotime($date."+ 1 days"))." 00:00:00";

                $payment_list = $payment_list->whereBetween('created_at', [$init_date, $final_date]);

                $msg = "No hay pagos registrados en la feha indicada.";
            }
            

            $grand_total_payment = $payment_list->sum('grand_total');

            $payment_list = $payment_list->skip($offset)
                                        ->take($rowsPerPage)
                                        ->get();

            if( count($payment_list) > 0 ){
                if($rowsPerPage <= $total){
                    $total_pages = 1;
                }
                $total_pages = ceil($total / $rowsPerPage);

                $this->res['total_pages'] = $total_pages;
                $this->res['data'] = $payment_list;
                $this->res['total'] = $total;
                $this->res['grand_total_payment'] = $grand_total_payment;

                $this->res['status'] = true;
            } else {
                $this->res['msg'] = $msg;
            }
        } catch(\Excpetion $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//GetPaymentList

    public function GetClient()
    {
        try {
            $user_slot_id = $this->request->input('user_slot_id');
            $user_slot = UsersSlots::find($user_slot_id);

            if($user_slot){
                $this->res['status'] = true;
                $this->res['data'] = $user_slot;
            } else {
                $this->res['msg'] = 'La cita no existe.';
            }

        } catch(\Excpetion $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//GetClient()

    public function MakeCharge()
    {
        try {
            $data = $this->request->all();
            $this->res['data'] = $data;

            $stock_product = ''; // HAY STOCK

            if(count($data['product_list']) > 0){
                foreach ($data['product_list'] as $kpl => $vpl) {
                    $product = Product::find($vpl['id']);
                    if($product){
                        if($product->stock >= $vpl['quantity']){
                        } else {
                            $stock_product = $product->name;
                        }
                    }
                }
            }

            if(empty($stock_product)){
                $payment = new Payment;
                $payment->user_slot_id      = $data['user_slot_id'];
                $payment->payment_type_id   = $data['type_id'];
                $payment->discount_id       = $data['discount_id'];
                $payment->subtotal          = $data['subtotal'];
                $payment->grand_total       = $data['grand_total'];
                $payment->payment_with      = $data['payment_with'];
                $payment->exchange          = $data['exchange'];
                $payment->total_service     = $data['total_service'];
                $payment->total_product     = $data['total_product'];
                $payment->save();

                if(count($data['service_list']) > 0){
                    foreach ($data['service_list'] as $ksl => $vsl) {
                        $service_payment = new ServicePayment;
                        $service_payment->payment_id    = $payment->id;
                        $service_payment->service_id    = $vsl['id'];
                        $service_payment->quantity      = $vsl['quantity'];
                        $service_payment->total         = $vsl['total'];
                        $service_payment->save();
                    }
                }

                if(count($data['product_list']) > 0){
                    foreach ($data['product_list'] as $kpl => $vpl) {
                        if($product->stock >= $vpl['quantity']){
                            $product_payment = new ProductPayment;
                            $product_payment->payment_id    = $payment->id;
                            $product_payment->product_id    = $vpl['id'];
                            $product_payment->quantity      = $vpl['quantity'];
                            $product_payment->total         = $vpl['total'];
                            $product_payment->save();   

                            if($product_payment->id != null){
                                $product = Product::find($vpl['id']);
                                
                                $stock_restante = (int)$product->stock-(int)$vpl['quantity'];
                                $product->stock = $stock_restante;
                                $product->save();
                            }
                            
                        }
                    }
                }

                $this->res['status'] = true;
                $this->res['msg'] = 'Venta guardada correctamente.';
            } else {
                $this->res['msg'] = 'No hay suficiente stock para el producto: .'.$stock_product;
            }
        } catch(\Excpetion $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//MakeCharge()

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
        //
    }

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
        //
    }
}////