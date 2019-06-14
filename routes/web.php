<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/scrap-from-etsy', 'EtsyScrapperController@extractMetaData');
Route::get('/scrap-from-templett', 'TemplettScrapperController@scrapURL');
Route::get('/scrap-from-templett-missing-redis', 'TemplettScrapperController@downloadMissingREDISTemplates');

Route::get('/translate/words', 'TranslatorController@translateWord');
Route::post('/translate/words/update', 'TranslatorController@updateWord');
Route::post('translate/words/save-translation', 'TranslatorController@saveTranslation');

Route::get('/translate/product-title', 'TranslatorController@translateProductTitle');
Route::post('/translate/product-title/update', 'TranslatorController@updateProductTitle');

Route::get('/', 'DesignerAppController@home');
Route::get('/app/get-thumbnails', 'DesignerAppController@getTemplateThumbnails');
Route::get('/app/get-additional-assets', 'DesignerAppController@loadAdditionalAssets');
Route::get('/app/get-bg-images', 'DesignerAppController@getBackgroundImages');
Route::get('/app/load-settings', 'DesignerAppController@loadSettings');
Route::get('/app/load-template', 'DesignerAppController@loadTemplate');

Route::post('/app/template/save-as', 'DesignerAppController@saveAs');
Route::post('/app/template/update', 'DesignerAppController@update');

Route::get('/app/get-remaining-downloads','DesignerAppController@loadRemainingDownloads');
Route::get('/app/get-woff-font-url', 'DesignerAppController@getWoffFontUrl');
Route::get('/app/check-allow-revert-template', 'DesignerAppController@checkAllowRevertTemplate');
Route::get('/app/get-css-fonts', 'DesignerAppController@getCSSFonts');
Route::post('/app/pdf', 'DesignerAppController@pdf');


