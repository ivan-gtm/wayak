<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ScrapFonts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scrapfonts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract font assets for template catalog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    function bulkFontsDownload(){
        
        // Collect all fonts are pending to download
        $fonts_to_download = DB::select('SELECT font_id FROM d_template_has_fonts WHERE status = ? LIMIT 1500', [0]);
        
        // print_r(sizeof($fonts_to_download));
        // exit;

        // Create relationship between font and template, if it does not exists
        if( sizeof($fonts_to_download) > 0 ){
            foreach( $fonts_to_download as $font ){
                // print_r($font->font_id);
                $this->downloadFont($font->font_id);
            }
        }

        // Set templates as status 2: Fonts have been downloaded
        /*
        DB::statement("UPDATE templates SET status = 2 WHERE template_id IN(
                            SELECT template_id FROM (
                                SELECT d_template_has_fonts.template_id, COUNT(d_template_has_fonts.id) fonts, SUM(d_template_has_fonts.status) downloaded_fonts 
                                FROM d_template_has_fonts, templates
                                WHERE d_template_has_fonts.template_id = templates.template_id
                                AND templates.status = 1
                                GROUP BY d_template_has_fonts.template_id
                                LIMIT 1000
                            ) fonts 
                            WHERE fonts = downloaded_fonts
                        )");
        */
        
        echo "\nTermine Fonts\n";
    }

    function customBulkFontDownload(){
        $fonts = [
            'font1',
            'font2',
            'font3',
            'font5',
            'font6',
            'font7',
            'font8',
            'font9',
            'font10',
            'font11',
            'font12',
            'font13',
            'font14',
            'font15',
            'font16',
            'font17',
            'font18',
            'font19',
            'font20',
            'font21',
            'font22',
            'font23',
            'font24',
            'font25',
            'font26',
            'font27',
            'font28',
            'font29',
            'font30',
            'font31',
            'font32',
            'font34',
            'font35',
            'font36',
            'font37',
            'font38',
            'font39',
            'font40',
            'font41',
            'font42',
            'font43',
            'font44',
            'font45',
            'font46',
            'font47',
            'font48',
            'font49',
            'font50',
            'font51',
            'font52',
            'font53',
            'font54',
            'font55',
            'font56',
            'font57',
            'font58',
            'font59',
            'font60',
            'font61',
            'font62',
            'font63',
            'font64',
            'font65',
            'font66',
            'font67',
            'font68',
            'font69',
            'font70',
            'font71',
            'font72',
            'font73',
            'font74',
            'font75',
            'font76',
            'font77',
            'font78',
            'font79',
            'font80',
            'font81',
            'font82',
            'font83',
            'font84',
            'font85',
            'font86',
            'font87',
            'font88',
            'font89',
            'font90',
            'font91',
            'font92',
            'font93',
            'font94',
            'font95',
            'font96',
            'font97',
            'font98',
            'font99',
            'font100',
            'font101',
            'font102',
            'font103',
            'font104',
            'font105',
            'font106',
            'font107',
            'font108',
            'font109',
            'font110',
            'font111',
            'font112',
            'font113',
            'font114',
            'font115',
            'font117',
            'font118',
            'font119',
            'font120',
            'font121',
            'font122',
            'font123',
            'font124',
            'font125',
            'font126',
            'font127',
            'font128',
            'font129',
            'font130',
            'font131',
            'font132',
            'font133',
            'font134',
            'font135',
            'font136',
            'font137',
            'font138',
            'font139',
            'font140',
            'font141',
            'font142',
            'font143',
            'font144',
            'font145',
            'font146',
            'font147',
            'font148',
            'font149',
            'font150',
            'font151',
            'font152',
            'font153',
            'font154',
            'font155',
            'font156',
            'font157',
            'font158',
            'font159',
            'font162',
            'font163',
            'font165',
            'font166',
            'font167',
            'font168',
            'font169',
            'font170',
            'font171',
            'font172',
            'font173',
            'font174',
            'font175',
            'font176',
            'font177',
            'font178',
            'font179',
            'font180',
            'font181',
            'font182',
            'font184',
            'font185',
            'font186',
            'font187',
            'font188',
            'font189',
            'font190',
            'font191',
            'font192',
            'font193',
            'font194',
            'font195',
            'font196',
            'font197',
            'font198',
            'font199',
            'font201',
            'font202',
            'font203',
            'font210',
            'font319',
            'font24172',
            'font24173',
            'font24240',
            'font24248',
            'font24278',
            'font24279',
            'font24283',
            'font24284',
            'font24424',
            'font24425',
            'font24427',
            'font24433',
            'font24434',
            'font24442',
            'font24875',
            'font24876',
            'font24877',
            'font24878',
            'font25018',
            'font25035',
            'font25102',
            'font25103',
            'font25104',
            'font25105',
            'font25188',
            'font25189',
            'font25190',
            'font25191',
            'font25192',
            'font25280',
            'font25287',
            'font25288',
            'font25934',
            'font25935',
            'font25936',
            'font25937',
            'font25938',
            'font25940',
            'font25941',
            'font25945',
            'font25946',
            'font25947',
            'font25948',
            'font25949',
            'font25950',
            'font26287',
            'font26313',
            'font26394',
            'font26395',
            'font26419',
            'font26430',
            'font26431',
            'font26432',
            'font26748',
            'font26903',
            'font27571',
            'font28140',
            'font28142',
            'font28143',
            'font28144',
            'font28382',
            'font29674',
            'font29693',
            'font29768',
            'font30357',
            'font30358',
            'font30359',
            'font30360',
            'font30361',
            'font30362',
            'font30363',
            'font31359',
            'font37178',
            'font38185',
            'font38186',
            'font38206',
            'font38862',
            'font38952',
            'font38953',
            'font38954'
        ];

        // echo sizeof($fonts);
        // exit;

        foreach ($fonts as $font_id) {
            $this->downloadFont($font_id);
            echo "Se ha descargado fuente $font_id\n";
            usleep(500000);
        }

    }

    function downloadFont( $font_id ){
        $original_font_url = 'https://templett.com/design/app/get-glyphs-by-font/'.$font_id;
            
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            // 'header'=>"Accept-language: en\r\n" .
            //           "Cookie: foo=bar\r\n"
          )
        );

        $context = stream_context_create($opts);

        $file = file_get_contents($original_font_url, false, $context);
        
        
        $font_info = json_decode($file);
        $url  = $font_info->url;
        $font_name = substr($font_info->url, strrpos($font_info->url, "/")+1, strlen($font_info->url));

        // print_r("\n");
        // print_r($font_info);
        // print_r($url);
        // print_r("\n");
        // exit;

        // Download font to server
        $path = public_path('design/fonts_new');
        
        @mkdir($path, 0777, true);

        set_time_limit(0);
        //This is the file where we save the    information
        $fp = fopen ($path . '/'.$font_name, 'w+');
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ","%20",$url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // get curl response
        curl_exec($ch); 
        curl_close($ch);
        fclose($fp);

        // Once we have font name we register this info on database
        $this->registerFontOnDB($font_id, $font_name);

    }

    function registerFontOnDB($font_id, $file_name){
        $font_exists = DB::table('fonts')
            ->select('font_id')
            ->where('font_id','=',$font_id)
            ->first();

        if( isset($font_exists->font_id) == false ){
            DB::table('fonts')->insert([
                    'font_id' => $font_id,
                    'name' => $file_name,
                    'status' => 1
                ]);
        }

        // Update all font db
        DB::table('d_template_has_fonts')
            ->where('font_id', $font_id)
            ->update(['status' => 1]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->bulkFontsDownload();
        // $this->customBulkFontDownload();
    }
}
