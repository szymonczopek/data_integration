<?php

namespace App\Http\Controllers;
use Console_Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;


class readFileController extends Controller
{
    public function readFile(){

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
            // wyjątek związanym z brakiem pliku
            return $e->getMessage();
        }


        foreach ($lines as $line) {
            ++$rowNumber;
            $elements = explode(";", $line);
            array_unshift($elements, $rowNumber);
            $rows[] = $elements;
        }
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
          //  echo "Liczba produktów ". $producentName. ": ".$producentCounter[$producentName]."</br>";
            $prodCount[] = $producentCounter[$producentName];
       }

        return response()->json([
            'rows' => $rows,
            'prodCount' => $prodCount],
            200)
            ->header('Content-Type', 'application/json');



    }
    public function displayMain(){
        return view('main');
    }
    public function displayStart(){
        return view('start');
    }

}
