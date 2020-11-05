<?php



// Route::get('/scrapper/over', 'overController@index');
// Route::get('/scrap-from-etsy', 'EtsyScrapperController@extractMetaData');
// Route::get('/scrap-from-templett', 'TemplettScrapperController@scrapURL');
// Route::get('/scrap-from-templett-missing-redis', 'TemplettScrapperController@downloadMissingREDISTemplates');


// FRONTEND
Route::get('/wayak', 'EditorController@wayak');
Route::get('/plantillas/invitaciones', 'EditorController@home1');
Route::get('/plantillas/producto-ejemplo', 'EditorController@product');
Route::get('/plantillas/category', 'EditorController@category');
// Route::get('/crello', 'EditorController@home');


// TRANSLATE
Route::get('/translate/words', 'TranslatorController@translateWord');
Route::post('/translate/words/update', 'TranslatorController@updateWord');
Route::post('/translate/words/save-translation', 'TranslatorController@saveTranslation');
Route::get('/translate/product-title', 'TranslatorController@translateProductTitle');
Route::post('/translate/product-title/update', 'TranslatorController@updateProductTitle');
Route::get('/translate/template', 'TranslatorController@translateTemplate');


// ADMIN
Route::get('/admin/manage-codes', 'AdminController@manageCodes')->name('code.manage');
Route::get('/admin/delete/code/{code}', 'AdminController@deleteCode')->name('code.delete');
Route::get('/admin/create/code/{code}', 'AdminController@createCode')->name('code.create');
Route::post('/admin/generate-code', 'AdminController@generateCode')->name('code.generate');
Route::get('/admin/create-product/{template_key}', 'AdminController@createProduct')->name('admin.createTemplate');
Route::post('/admin/create-product/{template_key}', 'AdminController@createDBProduct');
Route::get('/admin/mercado-pago/export/', 'AdminController@mercadoLibreExcel');

Route::post('/admin/mp/create-product/{template_key}', 'AdminController@editMPProduct');
Route::get('/admin/mp/create-product/{template_key}', 'AdminController@createMPProduct');

Route::get('/admin/etsy/templates/description', 'AdminController@descriptionTemplate');
Route::post('/admin/etsy/templates/description', 'AdminController@editDescriptionTemplate');
Route::get('/admin/db-missing-thumbs', 'AdminController@registerMissingTemplatesOnDB');
Route::get('/admin/explore', 'AdminController@manageTemplates')->name('admin.templates');
// CRELLO
Route::get('/admin/crello/download-templates', 'CrelloController@index');
Route::get('/admin/crello/translate-templates', 'CrelloController@translateTemplate');
Route::get('/admin/crello/explore','CrelloController@explore');
// GREEN
Route::get('/admin/green/explore', 'greenController@getFrontCategories');
Route::get('/admin/green/category/{category_id}/products', 'greenController@getFrontCategoryProducts');
Route::get('/admin/green/all-products', 'greenController@getAllProducts');
Route::get('/admin/green/all-categories', 'greenController@getAllCategories');
Route::get('/admin/green/translate-templates', 'greenController@translateTemplate');
Route::get('/admin/green/download-templates', 'greenController@index');


// DESIGNER
Route::get('/', 'EditorController@home');
// Route::get('/explore', 'EditorController@explore');
Route::get('/open', 'EditorController@open');

//EDITOR
Route::get('/editor/validate-code', 'EditorController@validateCode');
Route::post('/editor/validate-code', 'EditorController@validatePurchaseCode')->name('code.validate');
Route::get('/editor/get-thumbnails', 'EditorController@getTemplateThumbnails');
Route::get('/editor/load-template', 'EditorController@loadTemplate');

Route::post('/editor/template/update', 'EditorController@update');
Route::post('/editor/template/save-as', 'EditorController@saveAs');
Route::post('/editor/template/upload-image', 'EditorController@uploadImage');
Route::get('/editor/template/get-uploaded-image/{image_resource_id}', 'EditorController@getUploadedImage');

Route::get('/editor/get-additional-assets', 'EditorController@loadAdditionalAssets');
Route::get('/editor/get-bg-images', 'EditorController@getBackgroundImages');
Route::get('/editor/load-settings', 'EditorController@loadSettings');

Route::get('/editor/download-pdf', 'EditorController@downloadPDF');
Route::post('/editor/register-template-download', 'EditorController@registerTemplateDownload');
Route::get('/editor/get-remaining-downloads','EditorController@loadRemainingDownloads');

Route::get('/editor/get-woff-font-url', 'EditorController@getWoffFontUrl');
Route::get('/editor/check-allow-revert-template', 'EditorController@checkAllowRevertTemplate');
Route::get('/editor/get-css-fonts', 'EditorController@getCSSFonts');
Route::post('/editor/pdf', 'EditorController@generatePDF');


Route::get('/mx/editar/plantillas', 'EditorController@editPurchasedTemplate');