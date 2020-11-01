<?php

// SCRAPPER
Route::get('/scrapper/crello/download-templates', 'CrelloController@index');
Route::get('/scrapper/crello/translate-templates', 'CrelloController@translateTemplate');
Route::get('/scrapper/crello/library','CrelloController@explore');

Route::get('/scrapper/over', 'overController@index');
Route::get('/scrap-from-etsy', 'EtsyScrapperController@extractMetaData');
Route::get('/scrap-from-templett', 'TemplettScrapperController@scrapURL');
Route::get('/scrap-from-templett-missing-redis', 'TemplettScrapperController@downloadMissingREDISTemplates');

// CONTENT MIGRATION
Route::get('/green/categories', 'greenController@getFrontCategories');
Route::get('/green/category/products/{category_id}', 'greenController@getFrontCategoryProducts');
Route::get('/green/all-products', 'greenController@getAllProducts');
Route::get('/green/all-categories', 'greenController@getAllCategories');
Route::get('/green/translate-templates', 'greenController@translateTemplate');
Route::get('/scrapper/green/download-templates', 'greenController@index');

// FRONTEND
Route::get('/wayak', 'DesignerAppController@wayak');
Route::get('/plantillas/invitaciones', 'DesignerAppController@home1');
Route::get('/plantillas/producto-ejemplo', 'DesignerAppController@product');
Route::get('/plantillas/category', 'DesignerAppController@category');
// Route::get('/crello', 'DesignerAppController@home');


// TRANSLATE
Route::get('/translate/words', 'TranslatorController@translateWord');
Route::post('/translate/words/update', 'TranslatorController@updateWord');
Route::post('/translate/words/save-translation', 'TranslatorController@saveTranslation');
Route::get('/translate/product-title', 'TranslatorController@translateProductTitle');
Route::post('/translate/product-title/update', 'TranslatorController@updateProductTitle');
Route::get('/translate/template', 'TranslatorController@translateTemplate');

Route::get('/admin/manage-codes', 'AdminController@manageCodes')->name('code.manage');
Route::post('/admin/generate-code', 'AdminController@generateCode')->name('code.generate');
Route::get('/admin/templates', 'AdminController@manageTemplates')->name('admin.templates');
Route::get('/admin/create-product/{template_key}', 'AdminController@createProduct')->name('admin.createTemplate');
Route::post('/admin/create-product/{template_key}', 'AdminController@createDBProduct');

// DESIGNER
Route::get('/', 'DesignerAppController@home');
// Route::get('/explore', 'DesignerAppController@explore');
Route::get('/open', 'DesignerAppController@open');

Route::get('/app/validate-code', 'DesignerAppController@validateCode');
Route::post('/app/validate-code', 'DesignerAppController@validatePurchaseCode')->name('code.validate');
Route::get('/app/get-thumbnails', 'DesignerAppController@getTemplateThumbnails');
Route::get('/app/load-template', 'DesignerAppController@loadTemplate');

Route::post('/app/template/update', 'DesignerAppController@update');
Route::post('/app/template/save-as', 'DesignerAppController@saveAs');
Route::post('/app/template/upload-image', 'DesignerAppController@uploadImage');
Route::get('/app/template/get-uploaded-image/{image_resource_id}', 'DesignerAppController@getUploadedImage');

Route::get('/app/get-additional-assets', 'DesignerAppController@loadAdditionalAssets');
Route::get('/app/get-bg-images', 'DesignerAppController@getBackgroundImages');
Route::get('/app/load-settings', 'DesignerAppController@loadSettings');

Route::get('/app/download-pdf', 'DesignerAppController@downloadPDF');
Route::post('/app/register-template-download', 'DesignerAppController@registerTemplateDownload');
Route::get('/app/get-remaining-downloads','DesignerAppController@loadRemainingDownloads');

Route::get('/app/get-woff-font-url', 'DesignerAppController@getWoffFontUrl');
Route::get('/app/check-allow-revert-template', 'DesignerAppController@checkAllowRevertTemplate');
Route::get('/app/get-css-fonts', 'DesignerAppController@getCSSFonts');
Route::post('/app/pdf', 'DesignerAppController@generatePDF');
