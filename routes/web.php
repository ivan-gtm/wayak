<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\greenController;
use App\Http\Controllers\CrelloController;
use App\Http\Controllers\DesygnerController;
use App\Http\Controllers\overController;
use App\Http\Controllers\canvaController;

use App\Http\Controllers\EtsyScrapperController;
use App\Http\Controllers\TemplettScrapperController;

Route::get('/scrapper/over', [overController::class, 'index']);
Route::get('/scrapper/canva', [canvaController::class, 'index']);
Route::get('/scrapper/templett', [TemplettScrapperController::class, 'downloadOriginalTemplate']);
Route::get('/scrapper/templett/keynames', [TemplettScrapperController::class, 'migrateTemplateKeyNames']);

// Route::get( '/scrapper/etsy', [ EtsyScrapperController::class, 'extractMetaData' ]);
// Route::get('/scrap-from-templett', [TemplettScrapperController::class, 'scrapURL']);

// https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes#UNI2

// CUSTOMER

// FRONTEND EJEMPLO
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
    // TEMPORAL
    Route::get('/admin/refactor', [AdminController::class, 'refactor'])->name('admin.keyrefactor');

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
    Route::get('/admin/create-product/{template_key}', [AdminController::class, 'createProduct'])->name('admin.createTemplate');
    Route::post('/admin/create-product/{template_key}', [AdminController::class, 'createDBProduct']);

    Route::get('/admin/ml/templates/description', [AdminController::class, 'mlDescriptionTemplate'])->name('ml.getDescriptionMetadata');
    Route::post('/admin/ml/templates/description', [AdminController::class, 'editMlDescriptionTemplate'])->name('ml.editDescriptionMetadata');

    Route::get('/admin/mercadolibre/catalogo', [AdminController::class, 'mercadoLibreCatalog'])->name('admin.ml.mercadoLibreCatalog');
    Route::get('/admin/mercadolibre/excel/productos/{excel_id}', [AdminController::class, 'mercadoLibreExcelProducts'])->name('admin.ml.mercadoLibreExcelProducts');
    Route::get('/admin/ml/catalogo-excel', [AdminController::class, 'mercadoLibreExcel'])->name('admin.ml.generateProductExcel');
    Route::get('/admin/facebook/catalogo', [AdminController::class, 'facebookCSV'])->name('admin.fb.facebookCSV');
    
    // Route::get('/admin/ml/products/missing-metadata', [AdminController::class, 'getMissingMetadataTemplates'])->name('admin.ml.getMissingMetadataTemplates');
    Route::get('/admin/ml/product/edit-metadata/{template_key}', [AdminController::class, 'editMLMetadata'])->name('admin.ml.editMLMetadata');
    Route::post('/admin/ml/product/edit-metadata/{template_key}', [AdminController::class, 'editMPProduct']);
    
    Route::get('/admin/ml/templates/format-ready', [AdminController::class, 'getFormatReadyTemplates'])->name('admin.ml.getFormatReady');
    Route::get('/admin/ml/templates/missing-translation', [AdminController::class, 'getMissingTranslationTemplates'])->name('admin.ml.getMissingTranslation');
    Route::get('/admin/ml/templates/translation-ready', [AdminController::class, 'getTranslationReadyTemplates'])->name('admin.ml.getTranslationReady');
    Route::get('/admin/ml/templates/thumbnail-ready', [AdminController::class, 'getThumbnailReady'])->name('admin.ml.getThumbnailReady');
    Route::get('/admin/ml/templates/ready-for-sale', [AdminController::class, 'templatesReadyForSale'])->name('admin.ml.templatesReadyForSale');
    Route::get('/admin/ml/templates/missing-metadata', [AdminController::class, 'getMissingMetadataTemplates'])->name('admin.ml.getMissingMetadataTemplates');
    
    Route::get('/admin/ml/update-url', [AdminController::class, 'updateURL']);

// ETSY
    Route::get('/admin/etsy/templates/description', [AdminController::class, 'etsyDescriptionTemplate'])->name('etsy.editMetadata');
    Route::post('/admin/etsy/templates/description', [AdminController::class, 'editEtsyDescriptionTemplate']);

// DESYGNER
    Route::get('/admin/desygner/download-templates', [DesygnerController::class, 'index']);

// CRELLO
    Route::get('/admin/crello/explore', [CrelloController::class,'explore'])->name('crello.explore');
    Route::get('/admin/crello/download-templates', [CrelloController::class, 'index']);
    Route::get('/admin/crello/translate-templates', [CrelloController::class, 'translateTemplate']);
    // Route::get('/crello', [EditorController::class, 'home']);

// GREEN
    Route::get('/admin/green/explore', [greenController::class, 'getFrontCategories']);
    Route::get('/admin/green/all-products', [greenController::class, 'getAllProducts'])->name('green.products');
    Route::get('/admin/green/all-categories', [greenController::class, 'getAllCategories'])->name('green.categories');
    Route::get('/admin/green/category/{category_id}/products', [greenController::class, 'getFrontCategoryProducts']);
    Route::get('/admin/green/translate-templates', [greenController::class, 'translateTemplate']);
    Route::get('/admin/green/download-templates', [greenController::class, 'index']);

// TEMPLETT
    Route::get('/admin/templett/missing-translation', [TemplettScrapperController::class, 'missinTranslation']);
    Route::get('/admin/templett/bulk-translation/{from}/{to}', [TemplettScrapperController::class, 'bulkTranslation']);
    Route::post('/admin/templett/bulk-translation/{from}/{to}', [TemplettScrapperController::class, 'bulkTranslation'])->name('templett.bulkTranslate');
    
    

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
    
    
    // CONTENT
        Route::get('/{country}/search', [ContentController::class, 'showSearchPage']);

        Route::get('/{country}/templates/{category}', [ContentController::class, 'showCategoryPage']);
        // Route::get('/{country}/templates/{category}/{subcategory}', [EditorController::class, 'editPurchasedTemplate']);
        Route::get('/{country}/template/{template_id}/{slug}', [ContentController::class, 'showTemplatePage']);
        Route::get('/{country}/create/{category}', [ContentController::class, 'showCreatePage']);
        
        
        Route::get('/{country}/plantillas/{category}', [ContentController::class, 'showCategoryPage']);
        Route::get('/{country}/plantilla/{template_id}/{slug}', [ContentController::class, 'showTemplatePage']);
        Route::get('/{country}/crear/{category}', [ContentController::class, 'showCreatePage']);
        
        Route::get('/{country}/criar/{category}', [ContentController::class, 'showCategoryPage']);
        Route::get('/{country}/modelos/{category}', [ContentController::class, 'showCreatePage']);

        Route::get('/', [ContentController::class, 'showHome']);
        Route::get('mx', [EditorController::class, 'wayak_home']);

        // Route::get('mx/plantillas', [EditorController::class, 'home']);
        Route::get('{country}/demo/{modelo_mercado_pago}', [EditorController::class, 'demoTemplateEditor'])->name('plantilla.demo');
        Route::get('/{country}/editar/plantilla/{template_key}', [EditorController::class, 'customerTemplate'])->name('plantilla.editar');
        
    // -- https://wayak.app/us/templates/instagram-stories/

