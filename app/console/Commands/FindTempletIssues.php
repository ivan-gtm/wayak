<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class FindTempletIssues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:findtemplateissues';

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
     * @return mixed
     */
    public function handle()
    {
        $this->findTemplateIssues();
    }

    function findTemplateIssues(){

        $templates = DB::table('templates')
                            ->select('id', 'template_id')
                            ->where('status','=',3)
                            ->orderBy('id','DESC')
                            // ->limit(7000)
                            ->get();

        // print_r($templates);
        // exit;

        foreach ($templates as $template) {
            
            $template_key = 'template:'.$template->template_id.':jsondata';
            
            if(Redis::exists($template_key)){
                print_r($template->template_id);
                print_r("\n");
                print_r(Redis::exists($template_key));
                print_r("\n");    
            }
            
            // Redis::get($template_key);  
            /* 
            DB::table('templates')
                    ->where('template_id', $thumb_row->template_id)
                    ->update(['status' => 4]);
            */
        }
        
        echo "Termine thumbnails<br>";
    }
}
