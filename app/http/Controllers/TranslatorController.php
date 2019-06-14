<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


ini_set("max_execution_time", 0);   // no time-outs!
ignore_user_abort(true);            // Continue downloading even after user closes the browser.

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');

class TranslatorController extends Controller
{
	function createKeywordDB() {

        // $template_id_query = DB::table('templates')
        $keywords = DB::connection('store')->table('product_translations')
    		->select('product_id','name')
            // ->where('template_id','=',$template_id)
            // ->limit(1000)
            ->get();

        foreach ($keywords as $keyword) {
            preg_match_all('/(\w+)/', $keyword->name, $ress);
            
            foreach ($ress[0] as $word) {
                
                $word_exists = DB::table('keyword_translations')
                ->select('id','keyword','es_translation','occurrence')
                ->where('keyword','=',$word)
                ->first();

                if($word_exists) {
                    echo "<pre>";
                    print_r($word);

                    DB::table('keyword_translations')
							->where('id', $word_exists->id )
							->update(['occurrence' => $word_exists->occurrence + 1 ]);
                } else {
                    DB::table('keyword_translations')->insert([
                        'id' => null,
                        'keyword' => $word,
                        'es_translation' => null,
                        'occurrence' => 1
                    ]);
                }
            }
            
        }
        
        
        exit;

		

		return 0;
    }
    
    function translateWord(){
        $word = DB::table('keyword_translations')
        ->select('id','keyword')
        ->whereNull('es_translation')
        ->whereNull('has_translation')
        ->orderBy('occurrence','DESC')
        ->first();

        /*
        
        */

        

        /*
        DB::table('keyword_translations')
		    ->where('id', $word->id )
            ->update(
                [
                    'es_translation' => 'Invitación',
                    'has_translation' => 1
                ]
            );
        
        echo "<pre>";
        print_r($word);
        exit;
        */

        

        // 5184

        return view('translate_words',[ 'word' => $word ]);
    }

    function updateWord(Request $request){
        $word_id = $request->input('word_id');
        $has_translation = $request->input('has_translation');

        DB::table('keyword_translations')
		    ->where('id', $word_id )
            ->update(['has_translation' => $has_translation ]);

        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
        
    }

    function translateWordToOtherLang(Request $request){
        $word_id = $request->input('word_id');
        $has_translation = $request->input('has_translation');

        DB::table('keyword_translations')
		    ->where('id', $word_id )
            ->update(['has_translation' => $has_translation ]);

        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
        
    }

    function saveTranslation(Request $request){
        $word_id = $request->input('word_id');
        $translation = $request->input('translation');

        DB::table('keyword_translations')
		    ->where('id', $word_id )
            ->update(['es_translation' => $translation ]);

        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
        
    }

    function updateProductTitle(Request $request){
        $product_id = $request->input('product_id');
        $name_translation = $request->input('translation');
        /*
        DB::connection('store')
            ->table('product_translations')
		    ->where('id', $product_id )
            ->update(['es_translation' => $translation ]);
        */
        $translation_exists = DB::connection('store')
                ->table('product_translations')
                ->select('product_id','locale','name')
                ->where('locale','=','es')
                ->where('product_id','=',$product_id)
                ->first();

                if($translation_exists) {
                    DB::connection('store')
                            ->table('product_translations')
                            ->where('locale','=','es')
                            ->where('product_id','=',$product_id)
							->update([ 'name' => $name_translation ]);
                } else {
                    DB::connection('store')
                            ->table('product_translations')->insert([
                        'product_id' => $product_id,
                        'locale' => 'es',
                        'name' => $name_translation,
                        'description' => ''
                    ]);
                }

                DB::connection('store')
                            ->table('product_translations')
                            ->where('locale','=','en')
                            ->where('product_id','=',$product_id)
							->update([ 'tmp_status' => 1 ]); // Nombre traducido

        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
        
    }

    function translateProductTitle(){

        // SELECT * FROM `store`.`` LIMIT 0,1000
        $title = DB::connection('store')
        ->table('product_translations')
        ->select('product_id','name','tmp_name')
        ->where('locale','=','en')
        ->whereNull('tmp_status')
        ->orderBy('id','DESC')
        ->first();

        preg_match_all('/(\w+)/', $title->name, $title_words);
        
        $translated_words = $title_words[1];
        $translated_words_size = sizeof($translated_words);
        
        // echo "<pre>";
        // print_r($translated_words);
        // print_r($translated_words_size);
        // exit;

        for ($i=0; $i < $translated_words_size; $i++) {
            $translation = null;
            $translation = DB::table('keyword_translations')
            ->select('keyword','es_translation')
            ->where('keyword','=',$translated_words[$i])
            ->whereNull('has_translation')
            // ->orderBy('id','DESC')
            ->first();

            // echo "<pre>";
            // print_r($translation);
            if($translation){
                $translated_words[$i] = $translation->es_translation;
            } else {
                $translated_words[$i] = null;
            }
        }

        $title_words[1] = $translated_words;

        // echo "<pre>";
        // print_r($title);
        // print_r($title_words);
        // exit;

        return view('translate_product_titles',[ 
            'title' => $title, 
            'title_words' => $title_words 
        ]);
    }
}
