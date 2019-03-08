<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

use App\Day;
use App\DaysSlots;
use App\DateException;
use App\UsersSlots;

class DatingController extends Controller
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
        return view('dating.index', ['request' => $this->request]);
    }

    public function GetSchedules()
    {
        try{
            
            $days_slots = [
                'monday' => [
                    'list' =>[]
                ],
                'tuesday' => [
                    'list' =>[]
                ],
                'wednesday' => [
                    'list' =>[]
                ],
                'thursday' => [
                    'list' =>[]
                ],
                'friday' => [
                    'list' =>[]
                ],
                'saturday' => [
                    'list' =>[]
                ],
                'sunday' => [
                    'list' =>[]
                ]
            ];

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 1)->get();
            if( count($slots) > 0) $days_slots['monday']['list'] = $slots;

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 2)->get();
            if( count($slots) > 0) $days_slots['tuesday']['list'] = $slots;

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 3)->get();
            if( count($slots) > 0) $days_slots['wednesday']['list'] = $slots;

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 4)->get();
            if( count($slots) > 0) $days_slots['thursday']['list'] = $slots;

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 5)->get();
            if( count($slots) > 0) $days_slots['friday']['list'] = $slots;

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 6)->get();
            if( count($slots) > 0) $days_slots['saturday']['list'] = $slots;

            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', 7)->get();
            if( count($slots) > 0) $days_slots['sunday']['list'] = $slots;

            $exception_date_list = DateException::all();

            $this->res['exception_date_list'] = $exception_date_list;
            $this->res['data'] = $days_slots;
            $this->res['status'] = true;
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//GetSchedules

    public function DeleteSlot()
    {
        try{
            $slot_id = $this->request->input('slot_id');
            $day = $this->request->input('day');

            $day_slot = DaysSlots::find($slot_id);
            if($day_slot){
                $day_slot->delete();

                $day_id = null;
                $slots = [];
                if($day == 'monday') $day_id = 1;
                if($day == 'tuesday') $day_id = 2;
                if($day == 'wednesday') $day_id = 3;
                if($day == 'thursday') $day_id = 4;
                if($day == 'friday') $day_id = 5;
                if($day == 'saturday') $day_id = 6;
                if($day == 'sunday') $day_id = 7;

                $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', $day_id)->get();

                $this->res['status'] = true;
                $this->res['slots'] = $slots;
                $this->res['msg'] = 'El slot fue eliminado correctamente.';
            } else {
                $this->res['msg'] = 'El slot no existe.';
            }
        } catch(\Excpetion $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//DeleteSlot

    public function AddException()
    {
        try{
            $date = $this->request->input('date');

            $date_list = [];

            $search_repeated = DateException::where('date', $date)->count();

            if($search_repeated == 0){
                $new_exception = new DateException;
                $new_exception->date = $date;
                $new_exception->save();

                $date_list = DateException::all();

                $this->res['date_list'] = $date_list;
                $this->res['msg'] = 'Fecha agregada correctamente.';
                $this->res['status'] = true;
            } else {
                $this->res['msg'] = 'Esta fecha ya existe.';
            }

        } catch(\Exception $e) {
            $this->res['msg'] = 'Erorr en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//AddException()

    public function DeleteExceptionDate()
    {
        try {
            $id = $this->request->input('id');

            $delete_date = DateException::find($id);

            if($delete_date){
                $delete_date->delete();

                $date_list = DateException::all();

                $this->res['date_list'] = $date_list;
                $this->res['status'] = true;
                $this->res['msg'] = 'Fecha elminada correctamente.';
            } else {
                $this->res['msg'] = 'La fecha no existe.';
            }
        } catch(\Excpeiton $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//DeleteExceptionDate()

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
            $init_slot = $this->request->input('init_slot');
            $final_slot = $this->request->input('final_slot');
            $day = $this->request->input('day');

            $day_id = null;
            $slots = [];

            $days_slots = new DaysSlots;

            if($day == 'monday'){
                $day_id = 1;    
                $days_slots->day_id = $day_id;
            }
            if($day == 'tuesday'){
                $day_id = 2;
                $days_slots = new DaysSlots;
                $days_slots->day_id = $day_id;
            }
            if($day == 'wednesday'){ 
                $day_id = 3;
                $days_slots = new DaysSlots;
                $days_slots->day_id = $day_id;
            }
            if($day == 'thursday'){ 
                $day_id = 4;
                $days_slots = new DaysSlots;
                $days_slots->day_id = $day_id;
            }
            if($day == 'friday'){ 
                $day_id = 5;
                $days_slots = new DaysSlots;
                $days_slots->day_id = $day_id;
            }
            if($day == 'saturday'){ 
                $day_id = 6;
                $days_slots = new DaysSlots;
                $days_slots->day_id = $day_id;
            }
            if($day == 'sunday'){ 
                $day_id = 7;
                $days_slots = new DaysSlots;
                $days_slots->day_id = $day_id;
            }

            $days_slots->init_slot = $init_slot;
            $days_slots->final_slot = $final_slot;
            $days_slots->save();
            
            $slots = DaysSlots::select('id', 'day_id', 'init_slot', 'final_slot')->where('day_id', $day_id)->get();

            $this->res['status'] = true;
            $this->res['data'] = $slots;
            $this->res['msg'] = 'Slot agregado correctamente.';
        } catch(\Excpetion $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }// store

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

    public function MakeDatingIndex()
    {
        return view('dating.citas', ['request' => $this->request]);
    }//MakeDatingIndex()

    public function GetCitas()
    {
        try{
            $day = $this->request->input('day');
            $date = $this->request->input('date');

            $exception = DateException::where('date', $date)->count();

            if($exception == 0){
                $day_id = null;

                if($day == 1) $day_id = 1;
                if($day == 2) $day_id = 2;
                if($day == 3) $day_id = 3;
                if($day == 4) $day_id = 4;
                if($day == 5) $day_id = 5;
                if($day == 6) $day_id = 6;
                if($day == 0) $day_id = 7;

                $day_slots = DaysSlots::where('day_id', $day_id)->get();

                $users_slots = UsersSlots::where('date', $date)->get();

                foreach ($day_slots as $kdus => $vdus) {
                    $vdus->exist_cita = false;
                    $vdus->selected = false;
                }
                if(count($users_slots) > 0){
                    foreach ($users_slots as $kus => $vus) {
                        foreach ($day_slots as $kdus => $vdus) {
                            if($vus->day_slot_id == $vdus->id){
                                $vdus->exist_cita = true;// SI HAY UNA CITA REGISTRADA
                                $vdus->client_name  = $vus->name;
                                $vdus->user_slot_id = $vus->id;
                                $vdus->phone        = null;
                                $vdus->date        = $vus->date;
                            }
                        }
                    }
                }

                $this->res['day'] = $day;
                $this->res['data'] = $day_slots;
                $this->res['status'] = true;
            } else {
                $this->res['msg'] = 'Este día no hay citas.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//GetCitas()

    public function GetPublicCitas()
    {
        try{
            $day = $this->request->input('day');
            $date = $this->request->input('date');

            $exception = DateException::where('date', $date)->count();

            if($exception == 0){
                $day_id = null;

                if($day == 1) $day_id = 1;
                if($day == 2) $day_id = 2;
                if($day == 3) $day_id = 3;
                if($day == 4) $day_id = 4;
                if($day == 5) $day_id = 5;
                if($day == 6) $day_id = 6;
                if($day == 0) $day_id = 7;

                $day_slots = DaysSlots::where('day_id', $day_id)->get();

                $users_slots = UsersSlots::where('date', $date)->get();

                foreach ($day_slots as $kdus => $vdus) {
                    $vdus->exist_cita = false;
                    $vdus->selected = false;
                }
                if(count($users_slots) > 0){
                    foreach ($users_slots as $kus => $vus) {
                        foreach ($day_slots as $kdus => $vdus) {
                            if($vus->day_slot_id == $vdus->id){
                                $vdus->exist_cita = true;// SI HAY UNA CITA REGISTRADA
                                $vdus->client_name  = $vus->name;
                                $vdus->user_slot_id = $vus->id;
                                $vdus->phone        = null;
                                $vdus->date        = $vus->date;
                            }
                        }
                    }
                }

                $this->res['day'] = $day;
                $this->res['data'] = $day_slots;
                $this->res['status'] = true;
            } else {
                $this->res['msg'] = 'Este día no hay citas.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//GetPublicCitas()

    public function SaveCita()
    {
        try {
            $data['date']       = $this->request->input('date');
            $data['day_id']     = $this->request->input('day_id');
            $data['id']         = $this->request->input('id');
            $data['init_slot']  = $this->request->input('init_slot');
            $data['final_slot'] = $this->request->input('final_slot');

            $data['user']['id'] = null;
            $data['user']['name'] = null;
            $data['user']['phone'] = null;

            if(\Auth::check()){
                $r = $this->SaveCitaRegistered($data);
                if($r){
                    $this->res['status'] = true;
                    $this->res['msg'] = 'Cita Agendada Correctamente.';
                }
            } else {
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.';
        }
        return response()->json($this->res);
    }//SaveCita()

    public function SavePublicCita()
    {
        try {
            $data['date']       = $this->request->input('date');
            $data['day_id']     = $this->request->input('day_id');
            $data['id']         = $this->request->input('id');
            $data['init_slot']  = $this->request->input('init_slot');
            $data['final_slot'] = $this->request->input('final_slot');

            $data['name'] = $this->request->input('name');
            $data['phone'] = $this->request->input('phone');

            $data['user']['id'] = null;
            $data['user']['name'] = null;
            $data['user']['phone'] = null;


            $data['name'] = $this->request->input('name');
            $data['phone'] = $this->request->input('phone');

            $r = $this->SaveCitaPublic($data);
            if($r){
                $this->res['status'] = true;
                $this->res['msg'] = 'Cita Agendada Correctamente.';
            }

        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.';
        }
        return response()->json($this->res);
    }//SavePublicCita()

    private function SaveCitaRegistered($data)
    {
        try {
            $data['user']['id'] = \Auth::getUser()->id;
            $data['user']['name'] = \Auth::getUser()->first_name.' '.\Auth::getUser()->last_name;
            
            $r = $this->StoreCita($data);
            if($r){
                return true;
            } else {
                return false;
            }
        } catch(\Excpetion $e) {
            return false;
        }
    }//SaveCita()

    private function SaveCitaPublic($data)
    {
        try {
            $data['user']['id'] = null;
            $data['user']['name'] = $data['name'];
            $data['user']['phone'] = $data['phone'];
            
            $r = $this->StoreCita($data);
            if($r){
                return true;
            } else {
                return false;
            }
        } catch(\Excpetion $e) {
            return false;
        }
    }//SaveCitaPublic()

    private function StoreCita($data)
    {
        try {
            $cita               = new UsersSlots;
            $cita->user_id      = $data['user']['id'];
            $cita->date         = $data['date'];
            $cita->day_id       = $data['day_id'];
            $cita->day_slot_id  = $data['id'];
            $cita->init_slot    = $data['init_slot'];
            $cita->final_slot   = $data['final_slot'];
            $cita->name         = $data['user']['name'];
            $cita->phone        = $data['user']['phone'];

            $cita->save();
            return true;

        } catch(\Excpetion $e) {
            return false;
        }
    }//StoreCita()

    public function CitasListView()
    {
        return view('dating.list', ['request' => $this->request]);   
    }//CitasListView()


    public function MakeDatingIndexPublic()
    {
        return view('dating.public', ['request' => $this->request]);        
    }//MakeDatingIndexPublic()
}////
