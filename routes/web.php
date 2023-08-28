<?php

use App\Http\Controllers\AdminCodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\greenController;
use App\Http\Controllers\DesygnerController;
use App\Http\Controllers\CrelloController;
use App\Http\Controllers\OverController;
use App\Http\Controllers\canvaController;
use App\Http\Controllers\PlaceitController;
use App\Http\Controllers\CorjlController;
use App\Http\Controllers\FocoController;
use App\Http\Controllers\PacktController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TemplettScrapperController;
use App\Http\Controllers\LinkedInController;
use App\Http\Controllers\AdminSaleController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ProductHistoryController;

Route::get('/api/demo-url', [AdminController::class, 'getTemplateObjects']);

// SCRAPPER
    // Linkedin
        Route::get('/linked', [LinkedInController::class, 'index']);
    // PACKT
        Route::get('/packt', [PacktController::class, 'index']);
    // OVER
        Route::get('/admin/scrapper/over', [OverController::class, 'index']);
    // FOCO
        Route::get('/admin/scrapper/foco', [FocoController::class, 'index']);
    // CANVA
        Route::get('/admin/scrapper/canva', [canvaController::class, 'index']);
        Route::get('/admin/scrapper/canva/convert-json/{template_key}', [canvaController::class, 'convertToJSON']);
        Route::post('/admin/scrapper/canva/convert-json/{template_key}', [canvaController::class, 'convertToJSON'])->name('canva.convertToJSON');
    // CORJL
        Route::get('/admin/scrapper/corjl', [CorjlController::class, 'index']);
    // TEMPLETT
        Route::get('/admin/scrapper/templett', [TemplettScrapperController::class, 'downloadOriginalTemplate']);
        Route::get('/admin/scrapper/templett/keynames', [TemplettScrapperController::class, 'migrateTemplateKeyNames']);
        Route::get('/admin/scrapper/templett/missing-translation', [TemplettScrapperController::class, 'missinTranslation']);
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

    // PLACEIT
        Route::get('/admin/placeit', [PlaceitController::class, 'index']);


// Route::get('/scrap-from-templett', [TemplettScrapperController::class, 'scrapURL']);

// https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes#UNI2

// TRANSLATE
    // Route::get('/translate/words', [TranslatorController::class, 'translateWord']);
    // Route::post('/translate/words/update', [TranslatorController::class, 'updateWord']);
    // Route::post('/translate/words/save-translation', [TranslatorController::class, 'saveTranslation']);
    // Route::get('/translate/product-title', [TranslatorController::class, 'translateProductTitle']);
    // Route::post('/translate/product-title/update', [TranslatorController::class, 'updateProductTitle']);
    // Route::get('/translate/template', [TranslatorController::class, 'translateTemplate']);

// ADMIN
    // HOME
        Route::get('/admin', [AdminController::class, 'adminHome'])->name('admin.home');
        
        // Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');

    // CATEGORIES
        Route::get('/admin/categories', [CategoryController::class, 'manage'])->name('admin.category.manage');
        Route::get('/admin/campaign', [AdminSaleController::class, 'createCampaing'])->name('admin.create.campaing');
        Route::get('/admin/categories/translate/{from}/{to}', [CategoryController::class, 'translateCategory'])->name('admin.category.translate');
        
    // TEMPORAL
        Route::get('/admin/refactor', [AdminController::class, 'refactor'])->name('admin.keyrefactor');
        Route::get('/admin/thumbnail-generation', [AdminController::class, 'thumbnailGeneration'])->name('admin.thumbnailGeneration');
        
    // TEMPLATES TRANLATION
        Route::get('/admin/template/edit/{language_code}/{template_key}', [EditorController::class, 'adminTemplateEditor'])->name('admin.edit.template');

        Route::get('/admin/bulk-translate/{from}/{to}', [AdminController::class, 'bulkTranslate'])->name('admin.bulkTranslateText');
        Route::post('/admin/bulk-translate/{from}/{to}', [AdminController::class, 'bulkTranslate'])->name('admin.bulkTranslate');
        Route::get('/admin/template/translate/{template_key}/{from}/{to}', [AdminController::class, 'translateTemplateForm'])->name('admin.translate.templateForm');
        Route::post('/admin/template/translate/{template_key}/{from}/{to}', [AdminController::class, 'translateTemplate'])->name('admin.translate.template');
        Route::get('/admin/template/gallery/{country}', [AdminController::class, 'viewGallery'])->name('admin.template.gallery');
    // Sales    
        Route::get('/admin/sales', [AdminController::class, 'salesManager'])->name('admin.sales_manager');
        Route::post('/admin/sales', [AdminController::class, 'salesManager']);
        
    // Carousels
        Route::get('/admin/{country}/carousels/manage', [AdminController::class, 'carouselsManage'])->name('admin.carousels.manage');
        Route::post('/admin/{country}/carousels/home/update', [AdminController::class, 'updateHomeCarousel'])->name('admin.carousels.updateCarousels');

        Route::get('/admin/{country}/carousels/name', [AdminController::class, 'carouselsSetName'])->name('admin.carousels.step1');
        Route::get('/admin/{country}/carousels/items', [AdminController::class, 'carouselsSelectItems'])->name('admin.carousels.step2');
        Route::get('/admin/{country}/carousel/preview', [AdminController::class, 'getCarouselItemsPreview'])->name('admin.carousel.preview');
        Route::get('/admin/{country}/carousel/item/delete', [AdminController::class, 'deleteItem'])->name('admin.carousel.deleteItem');
        Route::get('/admin/{country}/carousels/items/create', [AdminController::class, 'carouselItemsCreate'])->name('admin.carousel.items.create');
        // Route::post('/admin/carousels', [AdminController::class, 'carouselsManager']);
    
    // Analytics
        Route::get('/admin/analytics/categories', [AdminController::class, 'analyticsCategories'])->name('admin.analyticsCategories');
        Route::get('/admin/analytics/templates', [AdminController::class, 'analyticsTemplates'])->name('admin.analyticsTemplates');
    
    // BOT
        Route::get('/admin/bot/templett/bulk-translation/{from}/{to}', [TemplettScrapperController::class, 'bulkTranslation']);
        Route::post('/admin/bot/templett/bulk-translation/{from}/{to}', [TemplettScrapperController::class, 'bulkTranslation'])->name('templett.bulkTranslate');
        Route::get('/admin/bot/generate-thumbs', [AdminController::class, 'generateProductThumbnails'])->name('admin.generateProductThumbnails');
        Route::get('/admin/bot/db-missing-thumbs', [AdminController::class, 'registerMissingTemplatesOnDB']);

    // KEYWORDS
        Route::get('/admin/metadata/keywords/manage', [AdminController::class, 'manageKeywords']);
        Route::post('/admin/metadata/keywords/manage', [AdminController::class, 'manageKeywords'])->name('admin.keywords.manage');
        Route::get('/admin/metadata/product', [AdminController::class, 'editProductName']);
        Route::post('/admin/metadata/product', [AdminController::class, 'editProductName'])->name('admin.metadata.product');

    // CODES ADMINISTRATION
        Route::get('/admin/{country}/codes/manage', [AdminCodeController::class, 'manageCodes'])->name('admin.code.manage');
        Route::get('/admin/{country}/codes/create', [AdminCodeController::class, 'createCode'])->name('admin.code.create');
        Route::get('/admin/{country}/codes/delete/{code}', [AdminCodeController::class, 'deleteCode'])->name('code.delete');
        // Route::post('/admin/{country}/generate-code', [AdminController::class, 'generateCode'])->name('code.generate');


// MARKETPLACE SELLING PRODUCTS
    // PRODUCT
        Route::get('/admin/create-product/{template_key}', [AdminController::class, 'createProduct'])->name('admin.createProduct');
        Route::post('/admin/create-product/{template_key}', [AdminController::class, 'createDBProduct']);

    // ETSY
        Route::get('/admin/etsy/thumbs/{template_id}', [AdminController::class, 'createEtsyProductThumbs'])->name('admin.etsy.thumbs');

        Route::get('/admin/etsy/gallery', [AdminController::class, 'etsyGallery'])->name('admin.etsy.templatesGallery');
        Route::get('/admin/gallery/vendor/{vendor}', [AdminController::class, 'getTemplatesByVendor'])->name('admin.templatesByVendor');
        Route::get('/admin/etsy/get-pdf/{template_id}', [AdminController::class, 'createEtsyPDF'])->name('admin.etsy.getPDF');
        
        Route::get('/admin/etsy/gallery/template-dashboard/{app}/{template_id}', [AdminController::class, 'getTemplateDashboard'])->name('admin.etsy.templateDashboard');
        Route::post('/admin/etsy/gallery/template-dashboard/{app}/{template_id}', [AdminController::class, 'getTemplateDashboard']);

        Route::get('/admin/etsy/gallery/template-assets/{app}/{template_id}', [AdminController::class, 'getTemplateAssets'])->name('admin.etsy.templateAssets');

        Route::get('/admin/etsy/templates/description', [AdminController::class, 'etsyDescriptionTemplate'])->name('admin.etsy.editMetadata');
        Route::post('/admin/etsy/templates/description', [AdminController::class, 'editEtsyDescriptionTemplate']);
        
    // Assets Gallery
        Route::get('/admin/assets-gallery/static', [AdminController::class, 'staticGallery'])->name('admin.staticGallery');
        Route::post('/admin/assets-gallery/update-status', [AdminController::class, 'updateAssetStatus'])->name('admin.assets.register_download');
        Route::get('/admin/assets-gallery/static/set-keywords/{img_id}', [AdminController::class, 'setIMGKeywords'])->name('admin.setIMGKeywords');
        Route::post('/admin/assets-gallery/static/set-keywords/{img_id}', [AdminController::class, 'setIMGKeywords'])->name('admin.saveKeywords');
        Route::get('/admin/assets-gallery/keywords/{search_param}', [AdminController::class, 'getKeywordRecomendations'])->name('admin.getKeywordRecomendations');
        Route::post('/admin/assets-gallery/multiple-keywords', [AdminController::class, 'saveMultipleKeywords'])->name('admin.saveMultipleKeywords');
        
    // FACEBOOK 
        Route::get('/admin/facebook/catalogo', [AdminController::class, 'facebookCSV'])->name('admin.fb.facebookCSV');
    
    // MERCADO LIBRE
        Route::get('/admin/ml/templates/description', [AdminController::class, 'mlDescriptionTemplate'])->name('ml.getDescriptionMetadata');
        Route::post('/admin/ml/templates/description', [AdminController::class, 'editMlDescriptionTemplate'])->name('ml.editDescriptionMetadata');

        Route::get('/admin/ml/catalogo', [AdminController::class, 'mercadoLibreCatalog'])->name('admin.ml.mercadoLibreCatalog');
        Route::get('/admin/ml/excel/productos/{excel_id}', [AdminController::class, 'mercadoLibreExcelProducts'])->name('admin.ml.mercadoLibreExcelProducts');
        Route::get('/admin/ml/catalogo-excel', [AdminController::class, 'mercadoLibreExcel'])->name('admin.ml.generateProductExcel');
        
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

// DESIGNER
    // Route::get('/open',  [EditorController::class,'open']);
    // Route::get('/explore',  [EditorController::class,'explore']);

// PRODUCT HISTORY
    Route::post('/syncProductHistory', [ProductHistoryController::class,'syncProductHistory']);
    Route::post('/removeProductFromHistory', [ProductHistoryController::class,'removeProductFromHistory']);
    Route::get('/getProductHistory', [ProductHistoryController::class,'getProductHistory']);

// CHECKOUT
    Route::get('/cart', [CheckoutController::class,'cart']);
    Route::get('/orders/create', [CheckoutController::class,'createOrder']);
    Route::get('/orders/capture', [CheckoutController::class,'capturePayment']);

//EDITOR
    Route::get('/editor/get-thumbnails', [EditorController::class,'getTemplateThumbnails']);
    Route::get('/editor/load-template', [EditorController::class,'loadTemplate']);

    Route::get('/{country}/editor/template/{template_key}', [EditorController::class, 'editTemplate'])->name('editor.editTemplate');
    Route::get('/{country}/template/open/{template_key}', [EditorController::class, 'openTemplate'])->name('editor.openTemplate');

    Route::post('/editor/template/update', [EditorController::class, 'update']);
    Route::post('/editor/template/save-as', [EditorController::class, 'saveAs']);
    Route::post('/editor/template/upload-image', [EditorController::class, 'uploadImage']);
    Route::get('/editor/template/get-uploaded-image/{image_resource_id}', [EditorController::class, 'getUploadedImage']);

    Route::get('/editor/get-additional-assets', [EditorController::class, 'loadAdditionalAssets']);
    Route::get('/editor/get-bg-images', [EditorController::class, 'getBackgroundImages']);
    Route::get('/editor/load-settings', [EditorController::class, 'loadSettings']);

    Route::get('/editor/download-pdf', [EditorController::class, 'downloadPDF']);
    Route::post('/editor/register-template-download', [EditorController::class, 'registerTemplateDownload']);
    Route::get('/editor/get-remaining-downloads/{template_id}', [EditorController::class,'loadRemainingDownloads']);
    Route::get('/editor/get-uploaded-images/{limit_image}/{load_count}', [EditorController::class,'getUploadedImages']);
    Route::get('/editor/get-related-products/{templateId_related}', [EditorController::class,'getRelatedProducts']);
    Route::get('/editor/get-backgrounds', [EditorController::class,'getBackgrounds']);

    Route::get('/editor/get-woff-font-url', [EditorController::class, 'getWoffFontUrl']);
    Route::get('/editor/check-allow-revert-template', [EditorController::class, 'checkAllowRevertTemplate']);
    Route::get('/editor/get-css-fonts', [EditorController::class, 'getCSSFonts']);
    Route::post('/editor/pdf', [EditorController::class, 'generatePDF']);

    Route::get('/{country}/editar/plantillas', [EditorController::class, 'editPurchasedTemplate']);
    
    
// FRONTEND
    
    // New frontend
    Route::get('/{country}/buscar', [ContentController::class, 'search'])->name('product.search');
    Route::get('/{country}/p/{slug}', [ContentController::class, 'getTemplate'])->name('product.template');
    Route::get('/{country}/demo/{product_id}', [ContentController::class, 'demo'])->name('product.demo');
    Route::get('/', [ContentController::class, 'showHome']);
    
    Route::get('/{country}', [ContentController::class, 'showHomePerPage'])->name('user.homepage');
    
    Route::get('/{country}/code', [CodeController::class, 'validateCode'])->name('code.validate.form');
    Route::post('/{country}/code', [CodeController::class,'redeemCode'])->name('code.validate');

    Route::get('/{country}/search', [ContentController::class, 'showSearchPage'])->name('user.search');

    // Search
    Route::get('/{country}/search/search-by-title', [ContentController::class,'searchByTitle']);
    Route::get('/{country}/search/search-by-title-and-category', [ContentController::class,'searchByTitleAndCategory']);
    Route::get('/{country}/search/count-by-format', [ContentController::class,'getFormatsTotals']);
    Route::get('/{country}/search/filter-by-search-term-and-price', [ContentController::class,'filterBySearchTermAndPrice']);

    Route::get('/{country}/templates/{cat_lvl_1}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel1');
    Route::get('/{country}/templates/{cat_lvl_1}/{cat_lvl_2}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel2');
    Route::get('/{country}/templates/{cat_lvl_1}/{cat_lvl_2}/{cat_lvl_3}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel3');
    Route::get('/{country}/templates/{cat_lvl_1}/{cat_lvl_2}/{cat_lvl_3}/{cat_lvl_4}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel4');
    
    Route::get('/{country}/template/{slug}', [ContentController::class, 'showTemplatePage'])->name('template.productDetail');

    Route::get('/{country}/plantillas/{category}', [ContentController::class, 'showCategoryPage']);
    Route::get('/{country}/plantilla/{template_id}/{slug}', [ContentController::class, 'showTemplatePage']);
    Route::get('/{country}/crear/{category}', [ContentController::class, 'showCreatePerCategoryPage']);
    Route::get('/{country}/crear', [ContentController::class, 'showCreatePage']);
    
    Route::get('/{country}/criar/{category}', [ContentController::class, 'showCategoryPage']);
    Route::get('/{country}/modelos/{category}', [ContentController::class, 'showCreatePage']);

    Route::get('/{country}/demo/{modelo_mercado_pago}', [EditorController::class, 'demoTemplateEditor'])->name('plantilla.demo');
    Route::get('/{country}/editar/plantilla/{template_key}', [EditorController::class, 'customerTemplate'])->name('plantilla.editar');

// SITEMAPS
    Route::get('/{country}/sitemap.xml', [ContentController::class, 'sitemap']);