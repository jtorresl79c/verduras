<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remision;
use App\Models\Pallet;
use Illuminate\Support\Facades\DB;
use PDF;
/* use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile; */

class IndexController extends Controller
{
    public function getAllRemisiones($id)
    {
     /*  $pallets = Pallet::all();

      ->where('links.id','!=',35)
      ->where('school_status.academic_year','=','2014-15')
 */
      $pallet = DB::table('remision')
          ->select('remision.id', 'remision.chofer','remision.fecha_envio','remision.producto')
          ->where('remision.id','=',$id)
          ->get();
        


     /*    $connector = new WindowsPrintConnector("4BARCODE-4B-2054A");
        $printer = new Printer($connector, $profile);
        $printer -> text("Hello World!\n");
        $printer -> cut();
 
        $printer -> close();
      dd($printer); */
         
        
       //$dimension= array(0,0,220,140);
       //$pdf = PDF::loadView('remision.etiquetas', compact('pallet'))->setPaper($dimension);
    // return $pdf->download('event-attendees.pdf');  
       return view ('remision.etiquetas',['pallet' => $pallet]);  
     //return $pdf->stream('event-attendees.pdf');
    }

    public function downloadPDF($id)
    {
        $pallet = DB::table('pallet')
        ->select('pallet.id', 'remision.chofer','remision.fecha_recibido','remision.producto')
        ->join('remision','pallet.id_remision','=','remision.id')
        ->where('remision.id','=',$id)
        ->get();

      $pdf = PDF::loadView('remision.tickets', compact('pallet'));

      return $pdf->stream('ticket.pdf');
    }
}
