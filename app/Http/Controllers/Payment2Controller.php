<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mail;
use App\User;
use App\Payment;
use App\Product;
use App\ServicePayment;
use App\ProductPayment;

use App\Group;

class Payment2Controller extends Controller
{
    
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['msg'] = '';
        $this->res['status'] = false;

        date_default_timezone_set('America/Mexico_City');
    }//__construct()

    public function resp(){
        $pa = new Group;
        $pa->name = 'Email';
        $pa->alias = 'Samuel Regino Placido';
        $pa->created_at = date('Y-m-d H:i:s');
        $pa->save();

        header ("Location: http://lololola.com.mx/sistema/public/statics/images/logo_dpilady_blanco.png");
    }


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
            $date_init = $this->request->input('date_init');
            $date_final = $this->request->input('date_final');
            
            $payment_list = [];
            $grand_total_payment = 0;

            $msg = 'No hay pagos registrados hasta el momento.';
            $rowsPerPage = 50;
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
                                        }, 'discount', 'payment_type'])->orderBy('created_at', 'DESC');

            if(isset($date_init) && isset($date_final)){
                $init_date = $date_init." 00:00:00";
                $final_date = date('Y-m-d', strtotime($date_final."+ 1 days"))." 00:00:00";

                $this->res['$init_date'] = $init_date;
                $this->res['$final_date'] = $final_date;

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
            $users_list = User::select('id', 'first_name', 'last_name', 'email', 'phone')
                                ->where('group_id', 4)->get();

            if(count($users_list) > 0){
                $this->res['status'] = true;
                $this->res['data'] = $users_list;
            } else {
                $this->res['msg'] = 'No hay clientes registrados.';
            }

        } catch(\Excpetion $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//GetClient()


    public function MakeCharge()
    {
        try{
            $data = $this->request->all();

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
                $payment->payment_type_id   = $data['type_id'];
                $payment->discount_id       = $data['discount_id'];
                $payment->subtotal          = $data['subtotal'];
                $payment->apply_advance_payment   = $data['apply_advance_payment'];
                $payment->advance_payment   = $data['advance_payment'];
                $payment->delivery_date     = $data['delivery_date'];
                $payment->grand_total       = $data['grand_total'];
                $payment->payment_with      = $data['payment_with'];
                $payment->exchange          = $data['exchange'];
                $payment->total_service     = $data['total_service'];
                $payment->total_product     = $data['total_product'];

                $payment->user_id       = $data['client']['id'];
                $payment->name          = $data['client']['name'];
                if(!empty($data['client']['phone'])) $payment->phone         = $data['client']['phone'];
                if(!empty($data['client']['email'])) $payment->email         = $data['client']['email'];

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

                    if(count($_FILES) == 0 ){
                        if(!empty($payment->email)){
                            //$this->SendEmailTicket($payment);
                        }   
                    }


                    $this->res['payment_id'] = $payment->id;
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

    public function UploadDesigns()
    {
        try{
            $data['payment_id']     = $this->request->payment_id;
            $uploaded_image_ban     = false;
            $final_image_name       = '';

            $payment_data = Payment::with([
                                            'service_payment' => function ($query){ $query->with('service'); }, 
                                            'product_payment' => function ($query){ $query->with('product');}, 
                                            'payment_type'
                                        ])
                                        ->where('id', $data['payment_id'])
                                        ->first();
            if($payment_data){
                if(count($_FILES) > 0 ){
                    $porciones = explode(".", $_FILES[ 'file' ]['name']);
                    $ext = $porciones[count($porciones)-1];
                    unset($porciones[count($porciones)-1]);
                    $name = implode("", $porciones);
                    $_FILES[ 'file' ]['name'] = $name.'.'.$ext;

                    list($txt, $ext) = explode(".", $_FILES[ 'file' ]['name']);
                    $rand = rand(1, 500);
                    $final_image_name = $rand."_".time().".".$ext;

                    if(move_uploaded_file($_FILES[ 'file' ]['tmp_name'], 'designs_images/'.basename($final_image_name))){
                        $uploaded_image_ban = true;

                        if($payment_data){
                            $payment_data->design_image = $final_image_name;
                            $payment_data->save();
                            $this->res['status'] = true;
                        }
                    } else {
                        $this->res['msg'] = 'Error al momento de subir el archivo, intente mas tarde.';
                    }
                }

                if(!empty($payment_data->email)){
                    $this->SendEmailTicket($payment_data, $uploaded_image_ban, $final_image_name);
                }
            } else {
                $this->res['msg'] = 'El Ticket de compra no existe.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//UploadDesigns()

    public function SendEmailTicket($payment_data, $uploaded_image_ban = false, $final_image_name = null)
    {
        $meses = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $date_created = explode( " ", $payment_data->created_at );
        $ff = explode( "-", $date_created[0] );
        $date = $ff[2].' de '.$meses[$ff[1]].' de '.$ff[0];
        $client_email = $payment_data->email;

        Mail::send('emails.ticket', ['data' => $payment_data, 'date' => $date], function($message) use ($client_email, $uploaded_image_ban, $final_image_name){
            $message->from('no-reply@lololola.com.mx', 'Lolo&Lola Boutique');
            $message->to([$client_email])->subject('Lolo&Lola Boutique')->bcc(['ventas@lololola.com.mx']);
            if($uploaded_image_ban){
                $message->attach(asset('/designs_images/').'/'.$final_image_name);
            }
        });
    }//SendEmailTicket()

    public function TicketWeb($folio)
    {
        $payment_data = Payment::with(
            ['service_payment' => 
            function ($query){
                $query->with('service');
            }, 'product_payment' => 
            function ($query){
                $query->with('product');
            }, 'payment_type'])->where('id', $folio)->first();

            $meses = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
            $date_created = explode( " ", $payment_data->created_at );
            $ff = explode( "-", $date_created[0] );
            $date = $ff[2].' de '.$meses[$ff[1]].' de '.$ff[0];

        return view('payment.ticket', ['request' => $this->request, 'data' => $payment_data, 'date' => $date]);
    }//TicketWeb()

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