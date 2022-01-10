<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Zip;

class TMPOverTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:over';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pupulate keyword mysql table';

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
        // /Volumes/BACKUP/wayak/public/
        $scan = scandir( public_path('over/design/template') );
        $template_index = 0;
        foreach($scan as $folder) {
            if(strlen($folder) > 3  && is_dir( public_path('over/design/template/'.$folder) ) ){
                // $template_id = $folder;

                print_r("\n".public_path('over/design/template/'.$folder.'/assets/'));
                print_r("\n");

                $zip = Zip::open( public_path('over/design/template/'.$folder.'/assets/'.$folder.'.zip' ) );
                $files =  $zip->listFiles();
                $zip->extract( public_path('over/design/template/'.$folder.'/assets/') );

                foreach ( $files as $filename ) {
                    if( str_starts_with($filename, 'OVRProjectImage') > 0 ){
                        // print_r("\n--".$filename);
                        $filename_path = public_path('over/design/template/'.$folder.'/assets/'.$filename);
                        rename($filename_path, $filename_path.".png");
                    }
                }

                unlink( public_path('over/design/template/'.$folder.'/assets/OVRProjectKey') );
                unlink( public_path('over/design/template/'.$folder.'/assets/OVRMetadataKey') );
                unlink( public_path('over/design/template/'.$folder.'/assets/'.$files[sizeof($files)-1]) );
                rmdir( public_path('over/design/template/'.$folder.'/assets/OVRRequiredFonts') );
                
                // unlink( public_path('over/design/template/'.$folder.'/assets/'.$folder.'.zip') );
                
                print_r($files);
                
                exit;

                // $template_folder = public_path('over/design/template/'.$folder);
                
                // public_path('over/design/template/'.$folder.'/assets/'.$folder.'.zip' ) );

                // $zip->extract('/path/to/uncompressed/files', array('file1','file2'));


            }
        }
    }
}
