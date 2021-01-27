<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateKeywords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createkeywords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $source_templates = DB::table('templates')
            // ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('tmp_etsy_metadata', 'tmp_etsy_metadata.id', '=', 'templates.fk_etsy_template_id')
            ->join('thumbnails', 'thumbnails.template_id', '=', 'templates.template_id')
            ->where('thumbnails.language_code','=','en')
            ->where('templates.status','=',5)
            ->whereNotNull('templates.fk_etsy_template_id')
            ->select('templates.template_id', 'templates.width', 'templates.height','templates.metrics','tmp_etsy_metadata.title','tmp_etsy_metadata.username','thumbnails.filename','thumbnails.title as title_','thumbnails.dimentions')
            ->get();


        foreach ($source_templates as $db_template) {
            $title = $db_template->title .'-'. $db_template->title_;
            preg_match_all('/([a-zA-Z])+/', $title, $final_title);

            if( isset($final_title[0]) ){
                $words = $final_title[0];
                foreach ($words as $word) {
                    
                    $word = trim( strtolower($word) );
                    
                    $db_word = DB::table('keywords')
                        ->where('word','=',$word)
                        ->where('language_code','=','en')
                        ->first();
                    
                    if( isset($db_word->id) ){
                        DB::table('keywords')
                            ->where('word','=', $word)
                            ->update([
                                'counter' => ($db_word->counter+1)
                            ]);
                    } else {
                        DB::table('keywords')->insert([
                            'id' => null,
                            'word' => $word,
                            'counter' => 1,
                            'is_tag' => false,
                            'is_valid_for_title' => false,
                            'language_code' => 'en'
                        ]);
                    } 

                }
            }
            
            print_r($title);
            print_r("REGEX >>");
            print_r($final_title[0]);

        }

        // 

        return 0;
    }
}
