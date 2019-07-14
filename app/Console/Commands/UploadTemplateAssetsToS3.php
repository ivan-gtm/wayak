<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;


class UploadTemplateAssetsToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:upload_assets_s3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload assets to S3';

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
        // $path = Storage::disk('s3')->put('images/originals', $request->file);
        $file = 'https://dsnegsjxz63ti.cloudfront.net/images/homeimages/landing/325cffc8df41a64.jpeg';
        $imageFileName = '325cffc8df41a64.jpeg';
        $filePath = '/billionbillion/' . $imageFileName;
        Storage::disk('s3')->put($filePath, file_get_contents($file),'public');

        // $s3 = \Storage::disk('s3');
        // $filePath = '/support-tickets/' . $imageFileName;
        // $s3->put($filePath, file_get_contents($image), 'public');

        // $request->merge([
        //     'size' => $request->file->getClientSize(),
        //     'path' => $path
        // ]);
        // $this->image->create($request->only('path', 'title', 'size'));
        // return back()->with('success', 'Image Successfully Saved');    
    }
}
