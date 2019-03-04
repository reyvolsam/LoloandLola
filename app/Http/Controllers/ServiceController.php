<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service;

use Validator;

class ServiceController extends Controller
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
        return view('service.index', ['request' => $this->request]);
    }//

    public function ListInterface()
    {
        try{
            $services = [];

            $services = Service::all();

            if(count($services) > 0){

                foreach ($services as $ks => $vs){
                    $vs->selected = false;
                    $vs->quantity = 1;
                    $vs->total = $vs->price;
                }

                $this->res['status'] = true;
                $this->res['data'] = $services;
            } else {
                $this->res['msg'] = 'No hay servicios registrados hasta el momento.';
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
    public function store()
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

            if (!$validator->fails()) {

                if($id == null){
                    $dup = Service::where('name', $data['name'])->count();

                    if($dup == 0){
                        $service = new Service;
                        $service->name = $data['name'];
                        $service->price = $data['price'];
                        $service->save();
        
                        $this->res['msg'] = 'Servicio guardado correctamente.';
                        $this->res['status'] = true;
                    } else {
                        $this->res['msg'] = 'El nombre del servicio ya existe.';
                    }
                } else {
                    $service = Service::find($id);

                    if($service){
                        $dup = Service::where('name', $data['name'])
                                        ->where('id', '!=', $service->id)
                                        ->count();
                        if($dup == 0){
                            $service->name = $data['name'];
                            $service->price = $data['price'];
                            $service->save();

                            $this->res['msg'] = 'Servicio actualizado correctamente.';
                            $this->res['status'] = true;
                        } else {
                            $this->res['msg'] = 'El nombre del servicio ya existe.';
                        }
                    } else {
                        $this->res['msg'] = 'El servicio seleccionado no existe.';
                    }

                }
            } else {
                $this->res['msg'] = 'Todos los campos son requeridos.';
            }
        } catch (\Excpetion $e){
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//store

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
            $service = Service::find($id);

            $service->delete();

            $this->res['msg'] = 'Servicio eliminado correctamente.';
            $this->res['status'] = true;
        } catch (\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }
}
