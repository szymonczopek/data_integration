<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
   function displayLaptop($id){
       $laptop = Laptop::findorfail($id);
       $message = '';

       $laptopData = array(
           '0' => (int)$laptop->id,
           '1' => (string)$laptop->manufacturer,
           '2' => (string)$laptop->size,
           '3' => (string)$laptop->resolution,
           '4' => (string)$laptop->screenType,
           '5' => (string)$laptop->touch,
           '6' => (string)$laptop->processorName,
           '7' => (int)$laptop->physicalCores,
           '8' => (int)$laptop->clockSpeed,
           '9' => (string)$laptop->ram,
           '10' => (string)$laptop->storage,
           '11' => (string)$laptop->discType,
           '12' => (string)$laptop->graphicCardName,
           '13' => (string)$laptop->memory,
           '14' => (string)$laptop->os,
           '15' => (string)$laptop->disc_reader
       );
       $oneLaptop[] = $laptopData;



       return response()->json([
           'laptop' => $oneLaptop,
           'message' => 'Zaimportowano wiersz o ID '.$id
       ],
           200)
           ->header('Content-Type', 'application/json');
}

function displayAllLaptops(){
       $laptops = Laptop::all();

       foreach ($laptops as $laptop) {
               $laptopData = array(
                   '0' => (int)$laptop->id,
                   '1' => (string)$laptop->manufacturer,
                   '2' => (string)$laptop->size,
                   '3' => (string)$laptop->resolution,
                   '4' => (string)$laptop->screenType,
                   '5' => (string)$laptop->touch,
                   '6' => (string)$laptop->processorName,
                   '7' => (int)$laptop->physicalCores,
                   '8' => (int)$laptop->clockSpeed,
                   '9' => (string)$laptop->ram,
                   '10' => (string)$laptop->storage,
                   '11' => (string)$laptop->discType,
                   '12' => (string)$laptop->graphicCardName,
                   '13' => (string)$laptop->memory,
                   '14' => (string)$laptop->os,
                   '15' => (string)$laptop->disc_reader
               );
               $laptopsArray[] = $laptopData;
           }
        return response()->json([
        'rows' => $laptopsArray,
        'message' => 'Import z bazy danych'
    ],
        200)
        ->header('Content-Type', 'application/json');
}

function newLaptop(Request $request){
    $parameters = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
      $laptop = $parameters[0];

      $newLaptop = Laptop::create([
          'manufacturer' => $laptop[1],
          'size'=> $laptop[2],
          'resolution'=> $laptop[3],
          'screenType'=> $laptop[4],
          'touch'=> $laptop[5],
          'processorName'=> $laptop[6],
          'physicalCores'=> $laptop[7],
          'clockSpeed'=> $laptop[8],
          'ram'=> $laptop[9],
          'storage'=> $laptop[10],
          'discType'=> $laptop[11],
          'graphicCardName'=> $laptop[12],
          'memory'=> $laptop[13],
          'os'=> $laptop[14],
          'disc_reader'=> $laptop[15]
      ]);

    return response()->json([
        'message' => 'Utworzono rekord'
    ],
        200)
        ->header('Content-Type', 'application/json');
}

function editLaptop(Request $request, $id){
    $parameters = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
    $laptop = $parameters->row;
    $laptop = $laptop[0];

    $editLaptop = Laptop::findorfail($id);
    $editLaptop->update([
        'manufacturer' => $laptop[1],
        'size'=> $laptop[2],
        'resolution'=> $laptop[3],
        'screenType'=> $laptop[4],
        'touch'=> $laptop[5],
        'processorName'=> $laptop[6],
        'physicalCores'=> $laptop[7],
        'clockSpeed'=> $laptop[8],
        'ram'=> $laptop[9],
        'storage'=> $laptop[10],
        'discType'=> $laptop[11],
        'graphicCardName'=> $laptop[12],
        'memory'=> $laptop[13],
        'os'=> $laptop[14],
        'disc_reader'=> $laptop[15],
    ]);

    return response()->json([
        'message' => 'Edytowano wiersz o ID '.$id
    ],
        200)
        ->header('Content-Type', 'application/json');
}

function deleteLaptop($id){
    $laptop = Laptop::findorfail($id);
    $laptop->delete();

    return response()->json([
        'message' => 'Usunieto wiersz o ID '.$id
    ],
        200)
        ->header('Content-Type', 'application/json');
}



}
