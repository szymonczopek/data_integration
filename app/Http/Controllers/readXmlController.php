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
    public function importXmlFile(){

        $filename = '../resources/files/katalog.xml';
        $xml = simplexml_load_file($filename);

        $laptops = array();

        foreach ($xml->laptop as $laptop) {
            $laptopData = array(
                '0' => (int) $laptop['id'],
                '1' => (string) $laptop->manufacturer,
                '2' => (string) $laptop->screen->size,
                '3' => (string) $laptop->screen->resolution,
                '4' => (string) $laptop->screen->type,
                '5' => (string) $laptop->screen['touch'],
                '6' => (string) $laptop->processor->name,
                '7' => (int) $laptop->processor->physical_cores,
                '8' => (int) $laptop->processor->clock_speed,
                '9' => (string) $laptop->ram,
                '10' => (string) $laptop->disc->storage,
                '11' => (string) $laptop->disc['type'],
                '12' => (string) $laptop->graphic_card->name,
                '13' => (string) $laptop->graphic_card->memory,
                '14' => (string) $laptop->os,
                '15' => (string) $laptop->disc_reader
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
            $laptop->addAttribute('id', $row[0]);

            $laptop->addChild('manufacturer', $row[1]);

            $screen = $laptop->addChild('screen');
            $screen->addAttribute('touch', $row[5]);
            $screen->addChild('size', $row[2]);
            $screen->addChild('resolution', $row[3]);
            $screen->addChild('type', $row[4]);

            $processor = $laptop->addChild('processor');
            $processor->addChild('name', $row[6]);
            $processor->addChild('physical_cores', $row[7]);
            $processor->addChild('clock_speed', $row[8]);

            $laptop->addChild('ram', $row[9]);

            $disc = $laptop->addChild('disc');
            $disc->addAttribute('type', $row[11]);
            $disc->addChild('storage', $row[10]);

            $graphic_card = $laptop->addChild('graphic_card');
            $graphic_card->addChild('name', $row[12]);
            $graphic_card->addChild('memory', $row[13]);

            $laptop->addChild('os', $row[14]);
            $laptop->addChild('disc_reader', $row[15]);
        }



        Storage::put($filePath, $xml->asXML());


        return response()->json([
            'message' => 'Plik XML wyekportowano pomyślnie'
        ],200)->header('Content-Type', 'application/json');
    }
}
