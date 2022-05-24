<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Remision;
use App\Models\Pallet;
use App\Models\drivers;
use DB;

class RemisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $remisiones = Remision::get();
        $drivers = drivers::orderBy('drivers_name','asc')->get();
        return view('remision.index', compact('remisiones','drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getLastRemision(){

            
        $invoice = Remision::orderBy('id','desc')->first();
        if($invoice){
            return $invoice->id + 1;
        }
        else{
            return 1;
        }

}


    public function RemisionList (Request $request){

        $remision = Remision::paginate(8);


    /*     if($request->invoice_id != ''){
    
            $invoice->where('id','=',$request->invoice_id);
        }

        if ($request->customer_id != ''){
            
            $invoice->where('customer_id','=',$request->customer_id);
        }  

        if ($request->start_date != '' && $request->end_date != ''){
            
            $invoice->whereBetween('sell_date',[$request->start_date,$request->end_date]);
        } */
      /*   $remision = $remision->paginate(10); */


        return $remision;
    }

    public function create()
    {
        return view('remision.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $request->validate([
            'customer_type' => 'required',
            'contenedor' => 'required',
            'producto' => 'required',
            'remision_no' =>'required|not_in:0',
            'drivers_id' => 'required_if:customer_type,1',
            'driver_name' => 'required_if:customer_type,2',
            'driver_email' => 'nullable|unique:customers,email',
            'driver_phone' => 'nullable|unique:customers,phone',
          ]); 
      
  
          try{
              DB::beginTransaction(); 
             
             // customer adding  
              if($request->customer_type == 1){
                $driver_id = $request['drivers_id']['id'];
              }
              else{
               
                  $driver = new drivers;
                  $driver->drivers_name = $request->driver_name;
                  $driver->email = $request->driver_email;
                  $driver->phone = $request->driver_phone;
                  $driver->address = $request->driver_address;
                  $driver->save();
                   
                  $driver_id = $driver->id;
              }

              $remision = new Remision;
              $remision->lote = '';
              $remision->remision = $request->remision_no;
              $remision->chofer =  $driver_id;
              $remision->contenedor = $request->contenedor;
              $remision->producto = $request->producto;
              $remision->kgs = $request->kgs;
              $remision->cajas = $request->cajas;
              $remision->recibio = $request->recibio;
              $remision->fecha_envio =date("Y-m-d", strtotime($request->envio_date));
              $remision->fecha_recibido = date("Y-m-d", strtotime($request->recibio_date));
              $remision->fecha_descarga = date("Y-m-d", strtotime($request->descarga_date));
              $remision->save();
              $LastInsertId = $remision->id;
        
             // $details = Pallet::where('id_remision','=',$id)->get();

       
              foreach ($request->remision as  $value) {
                
                $inv_pallet = new Pallet;
                $inv_pallet->id_remision = $LastInsertId;
                $inv_pallet->peso_bruto = $value['peso_bruto'];
                $inv_pallet->cajas = $value['cajas'];
                $inv_pallet->tara = $value['tara'];
                $inv_pallet->kg_prom = $value['kg_prom'];
                $inv_pallet->peso_neto = $value['peso_neto'];
                $inv_pallet->save();
             
             }
                     DB::commit();
                     return response()->json(['status' => 'success', 'message' => 'Remision creada !']);
                }
                catch(\Exception $e){
                
                DB::rollback();
                return $e;
                return response()->json(['status'=>'error','message'=>'Something Went Wrong!']);
            }
    


        
  
   

      /* return redirect()->back()->with('status','Se ha registrado correctamente'); */
    }

  
    public function show(Remision $remision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remision  $remision
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        
        $sell = Remision::find($id);

        $invoice_details = Pallet::where('pallet.id_remision','=',$id)->get();

        $arr = [
            'lote_no' => $sell->id,
            'remision_no' => $sell->remision,
            'drivers_id' =>  $sell->chofer,
            'contenedor' => $sell->contenedor,
            'producto' => $sell->producto,
            'kgs' => $sell->kgs,
            'cajas' => $sell->cajas,
            'recibio' => $sell->recibio,
            'envio_date' =>$sell->fecha_envio,
            'recibio_date' => $sell->fecha_recibido,
            'descarga_date' => $sell->fecha_descarga,
           
           'remision' => []

        ];
       
       $pallet = [];
       foreach ($invoice_details as $key => $value) {
           

            $inv_pallet = pallet::get();
            $inv_pallet['id'] = $value->id;
            $inv_pallet ['peso_bruto'] = $value->peso_bruto; 
            $inv_pallet ['cajas'] = $value->cajas; 
            $inv_pallet ['tara'] = $value->tara; 
            $inv_pallet ['kg_prom'] = $value->kg_prom; 
            $inv_pallet ['peso_neto'] = $value->peso_neto; 

          array_push($arr['remision'],$inv_pallet);
       }

        return $arr;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remision  $remision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contenedor' => 'required',
            'producto' => 'required',
            'remision_no' =>'required|not_in:0',
            'drivers_id' => 'required',
          ]); 
      
  
          try{

            DB::beginTransaction();
  
            $remision =Remision::find($id);
            $remision->lote = '';
            $remision->remision = $request->remision_no;
            $remision->chofer =  $request->drivers_id;
            $remision->contenedor = $request->contenedor;
            $remision->producto = $request->producto;
            $remision->kgs = $request->kgs;
            $remision->cajas = $request->cajas;
            $remision->recibio = $request->recibio;
            $remision->fecha_envio =date("Y-m-d", strtotime($request->envio_date));
            $remision->fecha_recibido = date("Y-m-d", strtotime($request->recibio_date));
            $remision->fecha_descarga = date("Y-m-d", strtotime($request->descarga_date));
            $remision->update();


            Pallet::where('id_remision','=',$id)->delete();

            foreach ($request->remision as  $value) {
                
                $inv_pallet = new Pallet;
                $inv_pallet->id_remision = $remision->id;
                $inv_pallet->peso_bruto = $value['peso_bruto'];
                $inv_pallet->cajas = $value['cajas'];
                $inv_pallet->tara = $value['tara'];
                $inv_pallet->kg_prom = $value['kg_prom'];
                $inv_pallet->peso_neto = $value['peso_neto'];
                $inv_pallet->save();
                 
            }

             
             DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Remision Actualizada !']);
            }
               catch(\Exception $e){
             
             DB::rollback();

             return $e;
             return response()->json(['status'=>'error','message'=>'Something Went Wrong!']);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remision  $remision
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remision $remision)
    {
        //
    }
}
