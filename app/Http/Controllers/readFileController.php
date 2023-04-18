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
    public function importTxtFile(){

        $tbl = new Console_Table();
        $tbl->setHeaders(
            array("Lp",
                "nazwa producenta",
                "przekątna ekranu",
                "rozdzielczość ekranu",
                "rodzaj powierzchni ekranu",
                "czy ekran jest dotykowy",
                "nazwa procesora",
                "liczba rdzeni fizycznych",
                "prędkość taktowania MHz",
                "wielkość pamięci RAM",
                "pojemność dysku",
                "rodzaj dysku",
                "nazwa układu graficznego",
                "pamięć układu graficznego",
                "nazwa systemu operacyjnego",
                "rodzaj napędu fizycznego w komputerze")
        );

        $rowNumber = 0;
        $rows = [];
        $filename = '../resources/files/katalog.txt';
        $producentNames = [];
        $producentCounter= [];


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
            $elements = explode(";", $line);
            array_unshift($elements, $rowNumber);
            $rows[] = $elements;
        }
        array_pop($rows);
        array_pop($rows);

       foreach ($rows as $row){
            $tbl->addRow($row);

            //zdefiniowanie nazw producentow
            if (!in_array($row[1],$producentNames,true) && trim($row[1]) !== ''){
                array_push($producentNames,$row[1]);
            }

        }
       foreach ($producentNames as $producentName){
            $producentCounter[$producentName] = 0;
        }

//zliczanie
        foreach ($rows as $row){
            foreach ($producentNames as $producentName) {
                if ($producentName === $row[1]) {
                    $producentCounter[$producentName]++;
                }
            }
        }

        //echo $tbl->getTable();


        foreach ($producentNames as $producentName){
          // echo "Liczba produktów ". $producentName. ": ".$producentCounter[$producentName]."</br>";
            $producentCount[] = $producentCounter[$producentName];
       }

        return response()->json([
            'rows' => $rows,
            'prodNames' => $producentNames,
            'prodCount' => $producentCount,
            'message' => 'Plik TXT zaimportowano pomyslnie'
        ],
            200)
            ->header('Content-Type', 'application/json');




    }
    public function displayTxtMain(){
        $header = ["Lp.","Producent", "Wielkość ekranu", "Rozdzielczość", "Rodzaj ekranu", "Ekran dotykowy",
            "Procesor", "Liczba rdzeni procesora", "Częstotliwość procesora", "RAM", "Pojemność dysku",
            "Typ dysku", "Karta graficzna", "Pamięć karty graficznej", "System operacyjny",
            "Napęd optyczny"];
        return view('main')/*->with('header', $header)*/;
}


   function exportTxtFile(Request $request){

       $parameters = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
       $laptops = $parameters->rows;

       $date = Carbon::now()->tz('Europe/Warsaw');;
      $fileName = 'plik_'.$date->format('d-m-y H-i-s').'.txt';
      $dir = 'exportTxt';
      Storage::makeDirectory($dir);
      $filePath = $dir.'/'.$fileName;


      foreach ($laptops as $laptop){
          $line = '';
          foreach ($laptop as $lap){
              $line .= $lap.';';
          }
          Storage::append($filePath, $line);
      }


       return response()->json([
           'message' => 'Plik TXT wyekportowano pomyślnie'
       ],200)->header('Content-Type', 'application/json');
   }

}
