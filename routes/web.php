<?php

use App\Http\Controllers\AdminCodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ProductHistoryController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\RecommendationController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesManagerController;

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

Route::get('/api/demo-url', [AdminController::class, 'getTemplateObjects']);

Route::prefix('admin')->middleware('auth')->group(function () {
    // SCRAPPER
        // Linkedin
            Route::get('/linked', [LinkedInController::class, 'index']);
        // PACKT
            Route::get('/packt', [PacktController::class, 'index']);
        // OVER
            Route::get('/scrapper/over', [OverController::class, 'index']);
        // FOCO
            Route::get('/scrapper/foco', [FocoController::class, 'index']);
        // CANVA
            Route::get('/scrapper/canva', [canvaController::class, 'index']);
            Route::get('/scrapper/canva/convert-json/{template_key}', [canvaController::class, 'convertToJSON']);
            Route::post('/scrapper/canva/convert-json/{template_key}', [canvaController::class, 'convertToJSON'])->name('canva.convertToJSON');
        // CORJL
            Route::get('/scrapper/corjl', [CorjlController::class, 'index']);
        // TEMPLETT
            Route::get('/scrapper/templett', [TemplettScrapperController::class, 'downloadOriginalTemplate']);
            Route::get('/scrapper/templett/keynames', [TemplettScrapperController::class, 'migrateTemplateKeyNames']);
            Route::get('/scrapper/templett/missing-translation', [TemplettScrapperController::class, 'missinTranslation']);
        // DESYGNER
            Route::get('/desygner/download-templates', [DesygnerController::class, 'index']);
        // CRELLO
            Route::get('/crello/explore', [CrelloController::class,'explore'])->name('crello.explore');
            Route::get('/crello/download-templates', [CrelloController::class, 'index']);
            Route::get('/crello/translate-templates', [CrelloController::class, 'translateTemplate']);
            // Route::get('/crello', [EditorController::class, 'home']);
        // GREEN
            Route::get('/green/explore', [greenController::class, 'getFrontCategories']);
            Route::get('/green/all-products', [greenController::class, 'getAllProducts'])->name('green.products');
            Route::get('/green/all-categories', [greenController::class, 'getAllCategories'])->name('green.categories');
            Route::get('/green/category/{category_id}/products', [greenController::class, 'getFrontCategoryProducts']);
            Route::get('/green/translate-templates', [greenController::class, 'translateTemplate']);
            Route::get('/green/download-templates', [greenController::class, 'index']);

        // PLACEIT
            Route::get('/placeit', [PlaceitController::class, 'index']);


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
            Route::get('', [AdminController::class, 'adminHome'])->name('admin.home');
            // Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');

        // CAMPAING / SALES 
        Route::get('/campaign', [SalesManagerController::class, 'createCampaing'])->name('admin.create.campaing');
        
        // AUTOCOMPLETE 
            Route::get('/{country}/autocomplete/add-term', [AutocompleteController::class,'addTerm']);

        // CATEGORIES
            Route::get('/categories', [CategoryController::class, 'manage'])->name('admin.category.manage');
            Route::get('/categories/translate/{from}/{to}', [CategoryController::class, 'translateCategory'])->name('admin.category.translate');
            
        // TEMPORAL
            Route::get('/refactor', [AdminController::class, 'refactor'])->name('admin.keyrefactor');
            Route::get('/thumbnail-generation', [AdminController::class, 'thumbnailGeneration'])->name('admin.thumbnailGeneration');
            
        // TEMPLATES TRANLATION
            Route::get('/template/edit/{language_code}/{template_key}', [EditorController::class, 'adminTemplateEditor'])->name('admin.edit.template');

            Route::get('/bulk-translate/{from}/{to}', [AdminController::class, 'bulkTranslate'])->name('admin.bulkTranslateText');
            Route::post('/bulk-translate/{from}/{to}', [AdminController::class, 'bulkTranslate'])->name('admin.bulkTranslate');
            Route::get('/template/translate/{template_key}/{from}/{to}', [AdminController::class, 'translateTemplateForm'])->name('admin.translate.templateForm');
            Route::post('/template/translate/{template_key}/{from}/{to}', [AdminController::class, 'translateTemplate'])->name('admin.translate.template');
            Route::get('/template/gallery/{country}', [AdminController::class, 'viewGallery'])->name('admin.template.gallery');
        // Sales    
            Route::get('/manage-campaign', [SalesManagerController::class, 'manageCampaign'])->name('admin.sales_manager');
            Route::post('/manage-campaign', [SalesManagerController::class, 'manageCampaign']);
            
        // Carousels
            Route::get('/{country}/carousels/manage', [AdminController::class, 'carouselsManage'])->name('admin.carousels.manage');
            Route::post('/{country}/carousels/home/update', [AdminController::class, 'updateHomeCarousel'])->name('admin.carousels.updateCarousels');

            Route::get('/{country}/carousels/name', [AdminController::class, 'carouselsSetName'])->name('admin.carousels.step1');
            Route::get('/{country}/carousels/items', [AdminController::class, 'carouselsSelectItems'])->name('admin.carousels.step2');
            Route::get('/{country}/carousel/preview', [AdminController::class, 'getCarouselItemsPreview'])->name('admin.carousel.preview');
            Route::get('/{country}/carousel/item/delete', [AdminController::class, 'deleteItem'])->name('admin.carousel.deleteItem');
            Route::get('/{country}/carousels/items/create', [AdminController::class, 'carouselItemsCreate'])->name('admin.carousel.items.create');
            // Route::post('/carousels', [AdminController::class, 'carouselsManager']);
        
        // Analytics
            Route::get('/analytics/categories', [AdminController::class, 'analyticsCategories'])->name('admin.analyticsCategories');
            Route::get('/analytics/templates', [AdminController::class, 'analyticsTemplates'])->name('admin.analyticsTemplates');
        
        // BOT
            Route::get('/bot/templett/bulk-translation/{from}/{to}', [TemplettScrapperController::class, 'bulkTranslation']);
            Route::post('/bot/templett/bulk-translation/{from}/{to}', [TemplettScrapperController::class, 'bulkTranslation'])->name('templett.bulkTranslate');
            Route::get('/bot/generate-thumbs', [AdminController::class, 'generateProductThumbnails'])->name('admin.generateProductThumbnails');
            Route::get('/bot/db-missing-thumbs', [AdminController::class, 'registerMissingTemplatesOnDB']);

        // KEYWORDS
            Route::get('/metadata/keywords/manage', [AdminController::class, 'manageKeywords']);
            Route::post('/metadata/keywords/manage', [AdminController::class, 'manageKeywords'])->name('admin.keywords.manage');
            Route::get('/metadata/product', [AdminController::class, 'editProductName']);
            Route::post('/metadata/product', [AdminController::class, 'editProductName'])->name('admin.metadata.product');

        // CODES ADMINISTRATION
            Route::get('/{country}/codes/manage', [AdminCodeController::class, 'manageCodes'])->name('admin.code.manage');
            Route::get('/{country}/codes/create', [AdminCodeController::class, 'createCode'])->name('admin.code.create');
            Route::get('/{country}/codes/delete/{code}', [AdminCodeController::class, 'deleteCode'])->name('admin.code.delete');
            // Route::post('/{country}/generate-code', [AdminController::class, 'generateCode'])->name('code.generate');

    // MARKETPLACE SELLING PRODUCTS
        // PRODUCT
            Route::get('/create-product/{template_key}', [AdminController::class, 'createProduct'])->name('admin.createProduct');
            Route::post('/create-product/{template_key}', [AdminController::class, 'createDBProduct']);

        // ETSY
            Route::get('/etsy/thumbs/{template_id}', [AdminController::class, 'createEtsyProductThumbs'])->name('admin.etsy.thumbs');

            Route::get('/etsy/gallery', [AdminController::class, 'etsyGallery'])->name('admin.etsy.templatesGallery');
            Route::get('/gallery/vendor/{vendor}', [AdminController::class, 'getTemplatesByVendor'])->name('admin.templatesByVendor');
            Route::get('/etsy/get-pdf/{template_id}', [AdminController::class, 'createEtsyPDF'])->name('admin.etsy.getPDF');
            
            Route::get('/etsy/gallery/template-dashboard/{app}/{template_id}', [AdminController::class, 'getTemplateDashboard'])->name('admin.etsy.templateDashboard');
            Route::post('/etsy/gallery/template-dashboard/{app}/{template_id}', [AdminController::class, 'getTemplateDashboard']);

            Route::get('/etsy/gallery/template-assets/{app}/{template_id}', [AdminController::class, 'getTemplateAssets'])->name('admin.etsy.templateAssets');

            Route::get('/etsy/templates/description', [AdminController::class, 'etsyDescriptionTemplate'])->name('admin.etsy.editMetadata');
            Route::post('/etsy/templates/description', [AdminController::class, 'editEtsyDescriptionTemplate']);
            
        // Assets Gallery
            Route::get('/assets-gallery/static', [AdminController::class, 'staticGallery'])->name('admin.staticGallery');
            Route::post('/assets-gallery/update-status', [AdminController::class, 'updateAssetStatus'])->name('admin.assets.register_download');
            Route::get('/assets-gallery/static/set-keywords/{img_id}', [AdminController::class, 'setIMGKeywords'])->name('admin.setIMGKeywords');
            Route::post('/assets-gallery/static/set-keywords/{img_id}', [AdminController::class, 'setIMGKeywords'])->name('admin.saveKeywords');
            Route::get('/assets-gallery/keywords/{search_param}', [AdminController::class, 'getKeywordRecomendations'])->name('admin.getKeywordRecomendations');
            Route::post('/assets-gallery/multiple-keywords', [AdminController::class, 'saveMultipleKeywords'])->name('admin.saveMultipleKeywords');
            
        // FACEBOOK 
            Route::get('/facebook/catalogo', [AdminController::class, 'facebookCSV'])->name('admin.fb.facebookCSV');
        
        // MERCADO LIBRE
            Route::get('/ml/templates/description', [AdminController::class, 'mlDescriptionTemplate'])->name('ml.getDescriptionMetadata');
            Route::post('/ml/templates/description', [AdminController::class, 'editMlDescriptionTemplate'])->name('ml.editDescriptionMetadata');

            Route::get('/ml/catalogo', [AdminController::class, 'mercadoLibreCatalog'])->name('admin.ml.mercadoLibreCatalog');
            Route::get('/ml/excel/productos/{excel_id}', [AdminController::class, 'mercadoLibreExcelProducts'])->name('admin.ml.mercadoLibreExcelProducts');
            Route::get('/ml/catalogo-excel', [AdminController::class, 'mercadoLibreExcel'])->name('admin.ml.generateProductExcel');
            
            // Route::get('/ml/products/missing-metadata', [AdminController::class, 'getMissingMetadataTemplates'])->name('admin.ml.getMissingMetadataTemplates');
            Route::get('/ml/product/edit-metadata/{template_key}', [AdminController::class, 'editMLMetadata'])->name('admin.ml.editMLMetadata');
            Route::post('/ml/product/edit-metadata/{template_key}', [AdminController::class, 'editMPProduct']);
            
            Route::get('/ml/templates/format-ready', [AdminController::class, 'getFormatReadyTemplates'])->name('admin.ml.getFormatReady');
            Route::get('/ml/templates/missing-translation', [AdminController::class, 'getMissingTranslationTemplates'])->name('admin.ml.getMissingTranslation');
            Route::get('/ml/templates/translation-ready', [AdminController::class, 'getTranslationReadyTemplates'])->name('admin.ml.getTranslationReady');
            Route::get('/ml/templates/thumbnail-ready', [AdminController::class, 'getThumbnailReady'])->name('admin.ml.getThumbnailReady');
            Route::get('/ml/templates/ready-for-sale', [AdminController::class, 'templatesReadyForSale'])->name('admin.ml.templatesReadyForSale');
            Route::get('/ml/templates/missing-metadata', [AdminController::class, 'getMissingMetadataTemplates'])->name('admin.ml.getMissingMetadataTemplates');
            
            Route::get('/ml/update-url', [AdminController::class, 'updateURL']);
});

// Functions in develop
Route::prefix('in-develop')->group(function () {
    
    // New frontend // beta
    Route::get('/{country}/buscar', [ContentController::class, 'search'])->name('product.search');
    Route::get('/{country}/p/{slug}', [ContentController::class, 'getTemplate'])->name('product.template');
    Route::get('/{country}/demo/{product_id}', [ContentController::class, 'demo'])->name('product.demo');

    // CHECKOUT
    Route::get('/{country}/cart', [CheckoutController::class, 'cart']);
    Route::get('/{country}/orders/create', [CheckoutController::class, 'createOrder']);
    Route::get('/{country}/orders/capture', [CheckoutController::class, 'capturePayment']);

    Route::get('/{country}/user/cart', [UserController::class, 'showCart']); // beta
    Route::get('/{country}/user/checkout', [UserController::class, 'showCheckout']); // beta
    
    // Manage collections (create or delete)
    Route::post('/{country}/user/favorites/collection/manage', [FavoritesController::class, 'manageCollection']); // beta

    // Get all collections for a client
    Route::get('/{country}/user/favorites/collections/{clientId}', [FavoritesController::class, 'getCollections']); // beta

    // DESIGNER
        // Route::get('/open',  [EditorController::class,'open']);
        // Route::get('/explore',  [EditorController::class,'explore']);

});

// User related functions
Route::group(['middleware' => ['guest']], function() {
    // Register Routes
    Route::get('/register', [RegisterController::class,'show'])->name('register.show');
    Route::post('/register', [RegisterController::class,'register'])->name('register.perform');

    // Login Routes
    Route::get('/login', [LoginController::class,'show'])->name('login.show');
    Route::post('/login', [LoginController::class,'login'])->name('login.perform');
    
    // Password Reset Routes...
    Route::get('password/reset', [LoginController::class,'showResetForm'])->name('password.resetForm');
    Route::post('password/email', [LoginController::class,'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [LoginController::class,'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [LoginController::class,'reset'])->name('password.update');
});

// FAVORITES
// Get all favorites for a client
Route::get('/{country}/user/favorites', [FavoritesController::class, 'showFavorites'])->name('user.favorites'); // beta
Route::prefix('favorites')->group(function () {
    // Add favorite
    Route::post('/add', [FavoritesController::class, 'addFavorite']);
    
    // Remove favorite
    Route::delete('/remove', [FavoritesController::class, 'removeFavorite']);
});

// recommendator
Route::get('/{country}/carousels', [RecommendationController::class, 'getUserCarousels'])->name('recommendator.carousels'); // beta

Route::group(['middleware' => ['auth']], function() {
    // Logout Routes
    Route::get('/{country}/logout', [LogoutController::class, 'perform'])->name('logout.perform');

    // PRODUCT HISTORY
    Route::post('/{country}/user/history/remove-product', [ProductHistoryController::class, 'removeProductFromHistory']);
    Route::get('/{country}/user/history/browsing', [ProductHistoryController::class, 'showBrowsingHistory']);
    Route::get('/{country}/user/history/search', [ProductHistoryController::class, 'showSearchHistory']);
    Route::get('/{country}/user/account', [UserController::class, 'showAccount']); 
});

// PRODUCT HISTORY
    Route::post('/product/history/sync', [ProductHistoryController::class,'syncProductHistory']);
    Route::get('/product/history', [ProductHistoryController::class,'getProductHistory']);

//EDITOR
    Route::get('/editor/get-thumbnails', [EditorController::class,'getTemplateThumbnails']);
    Route::get('/editor/load-template', [EditorController::class,'loadTemplate']);

    Route::get('/{country}/editor/template/{template_key}', [EditorController::class, 'editTemplate'])->name('editor.editTemplate');
    Route::get('/{country}/template/open/{template_key}', [EditorController::class, 'openTemplate'])->name('editor.openTemplate');
    Route::get('/{country}/template/demo/{template_key}', [EditorController::class, 'demoTemplate'])->name('editor.demoTemplate');

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
    
    
// Store
    Route::get('/', [ContentController::class, 'showHome']);
    
    Route::get('/{country}', [ContentController::class, 'showHomePerPage'])->name('user.homepage');
    
    Route::get('/{country}/code', [CodeController::class, 'validateCode'])->name('code.validate.form');
    Route::post('/{country}/code', [CodeController::class,'redeemCode'])->name('code.validate');

    // Search
    Route::get('/{country}/search', [SearchController::class, 'showSearchPage'])->name('user.search');
    
    // Autocompelte
    Route::get('/{country}/autocomplete', [AutocompleteController::class,'search']);
    Route::get('/{country}/search/popular-searches', [AutocompleteController::class, 'getTopSearches']);
    
    // Navigation by category
    Route::get('/{country}/templates/{cat_lvl_1}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel1');
    Route::get('/{country}/templates/{cat_lvl_1}/{cat_lvl_2}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel2');
    Route::get('/{country}/templates/{cat_lvl_1}/{cat_lvl_2}/{cat_lvl_3}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel3');
    Route::get('/{country}/templates/{cat_lvl_1}/{cat_lvl_2}/{cat_lvl_3}/{cat_lvl_4}', [ContentController::class, 'showCategoryPage'])->name('showCategoryLevel4');
    
    Route::get('/{country}/plantillas/{category}', [ContentController::class, 'showCategoryPage']);
    
    Route::get('/{country}/template/{slug}', [ContentController::class, 'showTemplatePage'])->name('template.productDetail');
    Route::get('/{country}/plantilla/{template_id}/{slug}', [ContentController::class, 'showTemplatePage']);

    Route::get('/{country}/crear/{category}', [ContentController::class, 'showCreatePerCategoryPage']);
    Route::get('/{country}/crear', [ContentController::class, 'showCreatePage']);
    
    Route::get('/{country}/criar/{category}', [ContentController::class, 'showCategoryPage']);
    Route::get('/{country}/modelos/{category}', [ContentController::class, 'showCreatePage']);

    // Route::get('/{country}/demo/{modelo_mercado_pago}', [EditorController::class, 'demoTemplateEditor'])->name('plantilla.demo');
    

// SITEMAPS
    Route::get('/{country}/sitemap.xml', [ContentController::class, 'sitemap']);