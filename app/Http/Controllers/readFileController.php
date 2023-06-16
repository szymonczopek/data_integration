<?php

namespace App\Http\Controllers;

use Console_Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class readFileController extends Controller
{
    public function displayMainView(){
        return view('main');
    }

    public function importCsvFile(){

        $rowNumber = 0;
        $rows = [];
        $filename = '../resources/files/katalog.csv';

        try {
            $lines = File::lines($filename);
        } catch (FileNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()],
                500)
                ->header('Content-Type', 'application/json');
        }

        foreach ($lines as $line) {
            ++$rowNumber;
            $rowNumber = strval($rowNumber);
            $elements = explode(",", $line);
            array_unshift($elements, $rowNumber);
            $rows[] = $elements;
        }
        array_pop($rows);
        array_pop($rows);

        return response()->json([
            'rows' => $rows,
            'message' => 'Plik CSV zaimportowano pomyslnie'
        ],
            200)
            ->header('Content-Type', 'application/json');

    }



   function exportCsvFile(Request $request){

       $parameters = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
       $laptops = $parameters->rows;
       $date = Carbon::now()->tz('Europe/Warsaw');
      $fileName = 'plik_'.$date->format('d-m-y H-i-s').'.csv';
      $dir = 'exportCsv';
      Storage::makeDirectory($dir);
      $filePath = $dir.'/'.$fileName;


      foreach ($laptops as $laptop){
          $line = '';
          foreach ($laptop as $lap){
              $line .= $lap.',';
          }
          Storage::append($filePath, $line);
      }


       return response()->json([
           'message' => 'Plik CSV wyekportowano pomyślnie'
       ],200)->header('Content-Type', 'application/json');
   }

}
