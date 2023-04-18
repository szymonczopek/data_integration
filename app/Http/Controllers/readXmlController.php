<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleXMLElement;

class readXmlController extends Controller
{
    public function displayXmlMain(){
        $header = ["Lp.","Producent", "Ekran dotykowy", "Wielkość ekranu", "Rozdzielczosc", "Rodzaj ekranu",
            "Procesor", "Liczba rdzeni procesora", "Częstotliwość procesora", "RAM",
            "Typ dysku","Pojemność dysku", "Karta graficzna", "Pamięć karty graficznej", "System operacyjny",
            "Napęd optyczny"];
        return view('main')->with('header', $header);
    }
    public function importXmlFile(){

        $filename = '../resources/files/katalog.xml';
        $xml = simplexml_load_file($filename);

        $laptops = array();

        foreach ($xml->laptop as $laptop) {
            $laptopData = array(
                'id' => (int) $laptop['id'],
                'manufacturer' => (string) $laptop->manufacturer,
                'screen' => array(
                    'touch' => (string) $laptop->screen['touch'],
                    'size' => (string) $laptop->screen->size,
                    'resolution' => (string) $laptop->screen->resolution,
                    'screenType' => (string) $laptop->screen->type
                ),
                'processor' => array(
                    'processorName' => (string) $laptop->processor->name,
                    'physical_cores' => (int) $laptop->processor->physical_cores,
                    'clock_speed' => (int) $laptop->processor->clock_speed
                ),
                'ram' => (string) $laptop->ram,
                'disc' => array(
                    'discType' => (string) $laptop->disc['type'],
                    'storage' => (string) $laptop->disc->storage
                ),
                'graphic_card' => array(
                    'graphic_cardName' => (string) $laptop->graphic_card->name,
                    'memory' => (string) $laptop->graphic_card->memory
                ),
                'os' => (string) $laptop->os,
                'disc_reader' => (string) $laptop->disc_reader
            );

            $laptops[] = $laptopData;
        }

        return response()->json([
            'rows' => $laptops,
            'message' => 'Plik XML zaimportowano pomyślnie'
        ],
            200)
            ->header('Content-Type', 'application/json');
    }
    public function exportXmlFile(Request $request){
        $parameters = json_decode($request->getContent(), true);
        $laptops = $parameters['rows'];

        $date = Carbon::now()->tz('Europe/Warsaw');;
        $fileName = 'plik_'.$date->format('d-m-y H-i-s').'.xml';
        $dir = 'exportXml';
        Storage::makeDirectory($dir);
        $filePath = $dir.'/'.$fileName;


        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><laptops></laptops>');
        $xml->addAttribute('moddate', $date);

        foreach ($laptops as $row) {
            $laptop = $xml->addChild('laptop');
            $laptop->addAttribute('id', $row['id']);

            $laptop->addChild('manufacturer', $row['manufacturer']);

            $screen = $laptop->addChild('screen');
            $screen->addAttribute('touch', $row['screen']['touch']);
            $screen->addChild('size', $row['screen']['size']);
            $screen->addChild('resolution', $row['screen']['resolution']);
            $screen->addChild('type', $row['screen']['screenType']);

            $processor = $laptop->addChild('processor');
            $processor->addChild('name', $row['processor']['processorName']);
            $processor->addChild('physical_cores', $row['processor']['physical_cores']);
            $processor->addChild('clock_speed', $row['processor']['clock_speed']);

            $laptop->addChild('ram', $row['ram']);

            $disc = $laptop->addChild('disc');
            $disc->addAttribute('type', $row['disc']['discType']);
            $disc->addChild('storage', $row['disc']['storage']);

            $graphic_card = $laptop->addChild('graphic_card');
            $graphic_card->addChild('name', $row['graphic_card']['graphic_cardName']);
            $graphic_card->addChild('memory', $row['graphic_card']['memory']);

            $laptop->addChild('os', $row['os']);
            $laptop->addChild('disc_reader', $row['disc_reader']);
        }



        Storage::put($filePath, $xml->asXML());


        return response()->json([
            'message' => 'Plik XML wyekportowano pomyślnie'
        ],200)->header('Content-Type', 'application/json');
    }
}
