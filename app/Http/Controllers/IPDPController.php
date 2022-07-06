<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use SVG\SVG;
// use Image;
// use Intervention\Image\ImageManagerStatic as Image;

use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Barryvdh\DomPDF\Facade as PDF;
use Image;

// use Intervention\Image;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use App\Models\Template;

// use App\Exports\MercadoLibreExport;
// use Maatwebsite\Excel\Facades\Excel;

// ini_set('memory_limit', -1);
// ini_set("max_execution_time", 0);   // no time-outs!
// ignore_user_abort(true);            // Continue downloading even after user closes the browser.

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


class IPDPController extends Controller
{
    function index(){
        return view('ipdp.home', []);
    }
    
    function login(){
        return view('ipdp.login', []);
    }
    
    function consultaIndigena(){
        return view('ipdp.consulta_indigena', []);
    }
    
    function recuperaContrasena(){
        return view('ipdp.recupera_contrasena', []);
    }
    
    function registraCedula(){
        return view('ipdp.registro_cedula', []);
    }
}
