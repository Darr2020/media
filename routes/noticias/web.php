<?php 

    /**
     * Página principal de noticias
     */
    Route::get('/noticias', 'NoticiasController@index')->name('noticias_main');

    /**
     * Pagina de noticias particular
     */
    Route::get('/ver/noticia/{id}', 'NoticiasController@showIndividual')->name('noticia_individual');

    /**
     * Pagina de noticias particular
     */
    Route::get('/ver/categoria/{id}', 'NoticiasController@categoria')->name('categoria_individual');
    
    /**
     * Noticias que se cargan en la pagina principal, infinite scroll
     */
    Route::get('/noticias/scroll/{page}', 'NoticiasController@infiniteMainScroll')->name('infinite_main_scroll');

    /**
     * Noticias que se cargan en la pagina de categoria, infinite scroll
     */
    Route::get('/categoria/scroll/{id}/{page}', 'NoticiasController@infiniteCategoryScroll')->name('infinite_categoria_scroll');
    
    /**
     * Modulo de gestion de noticias
     */
    Route::middleware("AuthenticationBackend")->prefix('backend')->group(function() {
        
        Route::get('/agregarNoticia', 'NoticiasController@newNoticia')->name('newNoticia')->middleware("profile:admin|editor|escritor");
        Route::get('/showNoticias', 'NoticiasController@showNoticiasBackend')->name('showNoticiasBackend')->middleware('profile:admin|editor|escritor');
        Route::get('/ver/test/{id}','NoticiasController@showIndividualTest')->name('individualTest')->middleware('profile:admin|editor|escritor');
        Route::get('/noticias/test', 'NoticiasController@indexTest')->name('noticias_test')->middleware('profile:admin|editor|escritor');
        Route::post('/addImage', 'NoticiasController@addImage')->name('addImage')->middleware('profile:admin|editor|escritor');
        Route::post('/removeImage', 'NoticiasController@removeImage')->name('removeImage')->middleware('profile:admin|editor|escritor');
        Route::post('/guardarNoticia', 'NoticiasController@guardarNoticia')->name('guardarNoticia')->middleware('profile:admin|editor|escritor');
        Route::get('/noticias/configuracion', 'NoticiasController@configuracionDeModulo')->name('configuracion_modulo')->middleware('profile:admin|editor|escritor');
        Route::get('/noticias/publicidad', 'NoticiasController@configuracionDePublicidad')->name('configuracion_publicidad')->middleware('profile:admin|editor');
        Route::get('/noticias/iframes', 'NoticiasController@configuracionDeIframes')->name('configuracion_iframes')->middleware('profile:admin|editor');
        Route::get('/noticias/scroll/{page}', 'NoticiasController@testScroll')->name('test_scroll')->middleware('profile:admin|editor|escritor');
        Route::get('/noticias/define/{key}', 'NoticiasController@defineSpecific')->name('define_specific_item')->middleware('profile:admin|editor|escritor');
        Route::post('/noticias/define', 'NoticiasController@updateDefinitions')->name('update_definitions')->middleware('profile:admin|editor');
        Route::post('/noticias/defineSpecElement', 'NoticiasController@defineSpecificElement')->name('define_specific_element')->middleware('profile:admin|editor|escritor');
        Route::post('/noticias/authorize', 'NoticiasController@authorizeChange')->name('authorize_change')->middleware('profile:admin|editor');
        Route::post('/noticias/modal', 'NoticiasController@displayModal')->name('display_modal')->middleware('profile:admin|editor');
        Route::post('/noticias/update', 'NoticiasController@updateConfig')->name('update_config')->middleware('profile:admin|editor');
        Route::post('/noticias/show-datatable','NoticiasController@noticiaServerSide')->name('datatable_noticia_serverside')->middleware('profile:admin|editor|escritor');
        Route::post('/noticias/publicar','NoticiasController@publicarNoticia')->name('publicar_noticia')->middleware('profile:admin|editor|escritor');
        Route::post('/noticias/showIframe','NoticiasController@showIframe')->name('show_iframe')->middleware('profile:admin|editor');
        Route::post('/noticias/showPublicidad','NoticiasController@showPublicidad')->name('show_publicidad')->middleware('profile:admin|editor');
        Route::post('/noticias/updateBanner','NoticiasController@updateBanner')->name('update_banner')->middleware('profile:admin|editor');
        Route::post('/noticias/updateNoticia','NoticiasController@updateNoticia')->name('update_noticia')->middleware('profile:admin|editor|escritor'); 
        Route::post('/noticias/updateMainConfig','NoticiasController@updateMainConfig')->name('update_main')->middleware('profile:admin|editor'); 
        
    });

    /**
     * Para usuarios registrados
     */
    Route::middleware("Authentication")->group(function() {
        /**
         * Agregar comentarios
         */
        Route::post('/comments/add', 'NoticiasController@addCommentsAction')->name('add_comentarios');
        /**
         * Like and Dislike
         */
        Route::get('/ver/noticia/{id}/{action}', 'NoticiasController@likeAndDislike')->name('like_dislike');
    });

?>