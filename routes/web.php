<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\greenController;
use App\Http\Controllers\CrelloController;
use App\Http\Controllers\EtsyScrapperController;

Route::get( '/scrapper/etsy', [ EtsyScrapperController::class, 'extractMetaData' ]);
// Route::get('/scrapper/over', [overController::class, 'index']);
// Route::get('/scrap-from-templett', [TemplettScrapperController::class, 'scrapURL']);
// Route::get('/scrap-from-templett-missing-redis', [TemplettScrapperController::class, 'downloadMissingREDISTemplates']);

// https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes#UNI2

// CUSTOMER
    Route::get('/', [EditorController::class, 'home']);
    Route::get('mx', [EditorController::class, 'home']);
    // Route::get('mx/plantillas', [EditorController::class, 'home']);
    Route::get('{country}/demo/{modelo_mercado_pago}', [EditorController::class, 'demoTemplateEditor'])->name('plantilla.demo');
    Route::get('/{country}/editar/plantilla/{template_key}', [EditorController::class, 'customerTemplate'])->name('plantilla.editar');

// FRONTEND EJEMPLO
    Route::get('mx/wayak', [EditorController::class, 'wayak']);
    Route::get('mx/plantillas/invitaciones', [EditorController::class, 'home1']);
    Route::get('mx/plantillas/producto-ejemplo', [EditorController::class, 'product']);
    Route::get('mx/plantillas/category', [EditorController::class, 'category']);

// TRANSLATE
    // Route::get('/translate/words', [TranslatorController::class, 'translateWord']);
    // Route::post('/translate/words/update', [TranslatorController::class, 'updateWord']);
    // Route::post('/translate/words/save-translation', [TranslatorController::class, 'saveTranslation']);
    // Route::get('/translate/product-title', [TranslatorController::class, 'translateProductTitle']);
    // Route::post('/translate/product-title/update', [TranslatorController::class, 'updateProductTitle']);
    // Route::get('/translate/template', [TranslatorController::class, 'translateTemplate']);

// ADMIN
    Route::get('/admin', [AdminController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/template/edit/{language_code}/{template_key}', [EditorController::class, 'adminTemplateEditor'])->name('admin.edit.template');

// TEMPLATES TRANLATION
    Route::get('/admin/bulk-translate/{from}/{to}', [AdminController::class, 'bulkTranslate'])->name('admin.bulkTranslateText');
    Route::post('/admin/bulk-translate/{from}/{to}', [AdminController::class, 'bulkTranslate'])->name('admin.bulkTranslate');
    Route::get('/admin/template/translate/{template_key}/{from}/{to}', [AdminController::class, 'translateTemplateForm'])->name('admin.translate.templateForm');
    Route::post('/admin/template/translate/{template_key}/{from}/{to}', [AdminController::class, 'translateTemplate'])->name('admin.translate.template');
    Route::get('/admin/template/gallery/{country}', [AdminController::class, 'viewGallery'])->name('admin.template.gallery');

// CODES ADMINISTRATION
    Route::get('/admin/{country}/manage-codes', [AdminController::class, 'manageCodes'])->name('admin.manageCodes');
    Route::get('/admin/{country}/delete/code/{code}', [AdminController::class, 'deleteCode'])->name('code.delete');
    Route::get('/admin/{country}/create/code/{code}', [AdminController::class, 'createCode'])->name('code.create');
    Route::post('/admin/{country}/generate-code', [AdminController::class, 'generateCode'])->name('code.generate');

// MERCADO LIBRE
    Route::get('/admin/ml/catalogo-excel', [AdminController::class, 'mercadoLibreExcel'])->name('admin.ml.generateProductExcel');
    // Route::get('/admin/ml/products/missing-metadata', [AdminController::class, 'getMissingMetadataTemplates'])->name('admin.ml.getMissingMetadataTemplates');
    Route::get('/admin/ml/product/edit-metadata/{template_key}', [AdminController::class, 'editMLMetadata'])->name('admin.ml.editMLMetadata');
    Route::post('/admin/ml/product/edit-metadata/{template_key}', [AdminController::class, 'editMPProduct']);
    
    Route::get('/admin/ml/templates/ready-for-sale', [AdminController::class, 'templatesReadyForSale'])->name('admin.ml.templatesReadyForSale');
    Route::get('/admin/ml/templates/format-ready', [AdminController::class, 'getFormatReadyTemplates'])->name('admin.ml.getFormatReady');
    Route::get('/admin/ml/templates/translation-ready', [AdminController::class, 'getTranslationReadyTemplates'])->name('admin.ml.getTranslationReady');
    Route::get('/admin/ml/templates/missing-translation', [AdminController::class, 'getMissingTranslationTemplates'])->name('admin.ml.getMissingTranslation');
    Route::get('/admin/ml/templates/missing-metadata', [AdminController::class, 'getMissingMetadataTemplates'])->name('admin.ml.getMissingMetadataTemplates');

// ETSY
    Route::get('/admin/etsy/templates/description', [AdminController::class, 'descriptionTemplate'])->name('etsy.editMetadata');
    Route::post('/admin/etsy/templates/description', [AdminController::class, 'editDescriptionTemplate']);

// CRELLO
    Route::get('/admin/crello/download-templates', [CrelloController::class, 'index']);
    Route::get('/admin/crello/translate-templates', [CrelloController::class, 'translateTemplate']);
    Route::get('/admin/crello/explore', [CrelloController::class,'explore'])->name('crello.explore');
    // Route::get('/crello', [EditorController::class, 'home']);

// GREEN
    Route::get('/admin/green/explore', [greenController::class, 'getFrontCategories']);
    Route::get('/admin/green/all-products', [greenController::class, 'getAllProducts'])->name('green.products');
    Route::get('/admin/green/all-categories', [greenController::class, 'getAllCategories'])->name('green.categories');
    Route::get('/admin/green/category/{category_id}/products', [greenController::class, 'getFrontCategoryProducts']);
    Route::get('/admin/green/translate-templates', [greenController::class, 'translateTemplate']);
    Route::get('/admin/green/download-templates', [greenController::class, 'index']);

Route::get('/admin/create-product/{template_key}', [AdminController::class, 'createProduct'])->name('admin.createTemplate');
Route::post('/admin/create-product/{template_key}', [AdminController::class, 'createDBProduct']);

Route::get('/admin/generate-thumbs', [AdminController::class, 'generateProductThumbnails'])->name('admin.generateProductThumbnails');

// DESIGNER
    // Route::get('/open',  [EditorController::class,'open']);
    // Route::get('/explore',  [EditorController::class,'explore']);
    
// SCRAPPER
    Route::get('/admin/db-missing-thumbs', [AdminController::class, 'registerMissingTemplatesOnDB']);
    

//EDITOR
    Route::get('/editor/validate-code', [EditorController::class, 'validateCode']);
    Route::post('/editor/validate-code', [EditorController::class,'validatePurchaseCode'])->name('code.validate');
    Route::get('/editor/get-thumbnails', [EditorController::class,'getTemplateThumbnails']);
    Route::get('/editor/load-template', [EditorController::class,'loadTemplate']);

    Route::post('/editor/template/update', [EditorController::class, 'update']);
    Route::post('/editor/template/save-as', [EditorController::class, 'saveAs']);
    Route::post('/editor/template/upload-image', [EditorController::class, 'uploadImage']);
    Route::get('/editor/template/get-uploaded-image/{image_resource_id}', [EditorController::class, 'getUploadedImage']);

    Route::get('/editor/get-additional-assets', [EditorController::class, 'loadAdditionalAssets']);
    Route::get('/editor/get-bg-images', [EditorController::class, 'getBackgroundImages']);
    Route::get('/editor/load-settings', [EditorController::class, 'loadSettings']);

    Route::get('/editor/download-pdf', [EditorController::class, 'downloadPDF']);
    Route::post('/editor/register-template-download', [EditorController::class, 'registerTemplateDownload']);
    Route::get('/editor/get-remaining-downloads', [EditorController::class,'loadRemainingDownloads']);

    Route::get('/editor/get-woff-font-url', [EditorController::class, 'getWoffFontUrl']);
    Route::get('/editor/check-allow-revert-template', [EditorController::class, 'checkAllowRevertTemplate']);
    Route::get('/editor/get-css-fonts', [EditorController::class, 'getCSSFonts']);
    Route::post('/editor/pdf', [EditorController::class, 'generatePDF']);

    Route::get('/{country}/editar/plantillas', [EditorController::class, 'editPurchasedTemplate']);