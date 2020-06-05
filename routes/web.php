<?php

/**
 * Rutas de Noticia
 */
require('noticias/web.php');

Route::get('404', function () { return view('404'); })->name('404');

Route::get('/iframe/topRanking','FrontendController@topRankingIframe')->name('iframe_topranking');

////////////////////////////         FRONTEND       ///////////////////////////
Route::get('/', 'FrontendController@principal')->name("pagina_principal");

Route::get('/logout', function() {
    Session::flush();
    return redirect()->route("pagina_principal");
})->name("cerrar_sesion");

///////////////////////////////////////////////////////////////////////////////
////////////////////////////         BACKEND        ///////////////////////////
Route::get('/backend', function () { return view('backend.login.login'); })->name("backend_login");

Route::get('/backend/registro', function () { return view('backend.login.register'); })->name("backend_registrar");

Route::get('/backend/recuperacion', function () { return view('backend.login.forgot'); })->name("backend_recuperar");

Route::get('/salir', function() {
    Session::flush();
    return redirect()->route("backend_login");
})->name("backend_salir");
//////////////////////////////////////////////////////////////////////////////////////
////////////////////////////          COMUN VERIFICAR USUARIO        /////////////////
Route::post('/checkb', 'UsuariosController@checkBAction')->name('login_checkb');
Route::post('/checkf', 'UsuariosController@checkFAction')->name('login_checkf');
////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
//////////////////     Registrarse - Frontend     /////////////////////////
Route::post('/registrarUF', 'UsuariosController@registerUserF')->name('registrarUF');

///////////////////////////////////////////////////////////////////////////////////////
////////////////////////           FRONTEND            //////////////////////////////// 
Route::post('/feelmm', 'GustosController@emitFeel');

////////////////////////         START DIANA           ///////////////////////////////
Route::post('categoria_detalle', 'FrontendController@categoria_detalle')->name("categoria_detalle");
Route::get('categoria_detalle', 'FrontendController@categoria_detalle')->name("categoria_detalle");
Route::post('/buscarvideocand', 'FrontendController@buscarvideo');
Route::post('/buscaraudio', 'FrontendController@buscaraudio');

///////////////////////////////////////   END DIANA   /////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////              RUTAS SEGUN PERFIL           ///////////////////////////// 
////////////////////////                 BACKEND                  //////// ////////////////////
Route::middleware("AuthenticationBackend")->prefix('backend')->group(function() {

    Route::get('/backend/inicio', function () {
        return redirect()->route("backend_inicio");
    });

    ///////////////////////////////////////      INICIO        //////////////////////////////////////////////////
    Route::get('inicio', 'BackendController@index')->name("backend_inicio");
    Route::get('config_params', 'BackendController@configParams')->name("backend_params");
    Route::get('/index_cfparams','BackendController@indexCfParams')->name("index_cfparams");
    Route::get('/admin_users','UsuariosController@indexAdminUsers')->name("admin_users");

    ///////////////////////////////////////     END INICIO    //////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////   START ENC TLF  ///////////////////////////////////////////
    Route::get('/enc_index', 'EncuestaController@encuestaIndex')->name("enc_tlf_index");
    Route::get('enc_tlfP1', 'EncuestaController@encuestaTlfP1')->name("enc_tlfP1");
    Route::get('/enc_tlfP2/{id?}', 'EncuestaController@encuestaTlfP2')->name("enc_tlfP2");
    Route::get('enc_tlfShow/{id?}', 'EncuestaController@encuestaTlfShow')->name("enc_tlfShow");
    Route::get('cand_categ', 'EncuestaController@candidatosPorCategoria')->name("cand_categ");
    Route::get('search_cateCand', 'EncuestaController@buscarCandidatosPorCateg')->name('search_cateCand');
    Route::get('show_enc_cate', 'EncuestaController@mostrarEncuestaPorCategoria')->name("show_enc_cate");
    Route::get('/enc_tlf_p1mod/{id?}', 'EncuestaController@encuestaTlfP1Mod')->name("enc_tlf_p1mod");

    ///////////////////////////////////////   END ENC TLF    /////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////    ENCUESTA WEB              //////////////////////////////////////
    Route::get('encweb_index', 'EncuestaController@encuestaWebIndex')->name("encweb_index");
    Route::get('/encwebP2/{id?}', 'EncuestaController@encuestaWebTlfP2')->name("encwebP2");
    Route::get('encwebShow/{id?}', 'EncuestaController@encuestaTlfShowWeb')->name("encwebShow");
    Route::get('encweb_search_cateCand', 'EncuestaController@buscarCandidatosPorCategWeb')->name('encweb_search_cateCand');
    Route::get('encweb_show_cate', 'EncuestaController@mostrarEncuestaPorCategoriaWeb')->name("encweb_show_cate");

    ////////////////////////////////////// END ENC WEB  ///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////       USUARIOS BACKEND       //////////////////////////////////////
    Route::get('/userb_cp','UsuariosController@cambiarClaveUserb')->name("userb_cp");
   
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////   START DIANA   //////////////////////////////////////////////////
    Route::get('categoria', 'Categoria\CategoriaController@index')->name("crear_categoria");
    Route::get('carea/', 'Categoria\CategoriaController@consulCat')->name("consultar_categoria");
    Route::get('area', 'Categoria\CategoriaController@consulCateg')->name("crear_candidato");
    Route::get('ccateg', 'Candidato\CandidatoController@consulCandit')->name("consultar_candidato");
    Route::get('carrusel', 'Frontend\FrontendController@carousel')->name("admin_carrusel");
    Route::get('poscatg', 'Frontend\FrontendController@posicioncatg')->name("admin_posicion");

    Route::post('crearCategoria', 'Categoria\CategoriaController@guardarCateg');
    Route::post('busCatg', 'Categoria\CategoriaController@getCatg');
    Route::post('busCand', 'Candidato\CandidatoController@getCandit');
    Route::post('crearCandidato', 'Candidato\CandidatoController@guardarCandiop');
    Route::post('buscandoCandidato', 'Candidato\CandidatoController@buscandoCandidato');
    Route::post('activaciones', 'Categoria\CategoriaController@activaciones');
    Route::post('cambiarColor', 'Frontend\FrontendController@cambiarColor');
    Route::post('crearBanner', 'Frontend\FrontendController@guardarBanner');

    ///////////////////////////////////////   END DIANA   ///////////////////////////////////////////////
});


Route::middleware('AuthAjax')->group(function() {
    ////////////////////////    START ENC TLF  AJAX        ////////////////////////////////////
    Route::post('/save_poll', 'EncuestaController@guardarEncuesta')->name('verificar_archivo');
    Route::post('/ppoll_push', 'EncuestaController@publicarEncTlf')->name('ppoll_push');
    Route::post('/enc_web_tlf', 'EncuestaController@encuestaWebTlf')->name("enc_web_tlf");
    Route::post('/wpoll_push', 'EncuestaController@publicarEncWeb')->name('wpoll_push');
    Route::post('/enc_web_vacia', 'EncuestaController@encuestaWebVacia')->name("enc_web_vacia");
    Route::post('/remover_ec', 'EncuestaController@removerCandDeEncuestaCandidato')->name('remover_ec');
    Route::post('/verifyData', 'EncuestaController@verifyData')->name('verify_data');
    Route::post('/verifyDataEncWeb', 'EncuestaController@verifyDataEncWeb')->name('verify_data_web');
    Route::post('/verifyDataEOWeb', 'EncuestaController@verifyDataEncOWeb')->name('verify_data_oweb');
    Route::post('/saveiOrdPto', 'EncuestaController@guardarIniOrdPto')->name('saveiOrdPto');
    Route::post('/enc_web_ult', 'EncuestaController@encuestaWebClonar')->name("enc_web_ult");
    Route::post('/remover_cat_etlf', 'EncuestaController@removerCategoriaDeEncTlf')->name('remover_cat_etlf');
    Route::post('/remover_cat_eweb', 'EncuestaController@removerCategoriaDeEncWeb')->name('remover_cat_eweb');
    Route::post('/update_poll', 'EncuestaController@actualizarEncuesta')->name('verifyUpFile');
    Route::post('/enc_tlf_ult', 'EncuestaController@encuestaTlfClonar')->name("enc_tlf_ult");
    ////////////////////////    END ENC TLF  AJAX        //////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////             Modal Login/Registrar/Recuperar - Frontend     ///////////////////////
    Route::post('/authf', 'UsuariosController@loginFrontendModal')->name('authf');
    Route::post('/registerf', 'UsuariosController@registerFrontendModal')->name('registerf');
    Route::post('/forgotpf', 'UsuariosController@forgotPasswFrontendModal')->name('forgotpf');
    ///////////////////    END Modal Login/Registrar/Recuperar - Frontend  AJAX  ////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////               START CONFIG PARAMETROS                 ///////////////////////////
    Route::post('/update_confpa', 'BackendController@actualizarConfParams')->name('update_confParams');
    Route::post('/new_cf_param', 'BackendController@newConfParams')->name('new_cf_param');
    Route::post('/edit_cf_param', 'BackendController@editConfParams')->name('edit_cf_param');

    ///////////////////                    END CONFIG PARAMETROS AJAX            ////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////                  START USUARIOS BACKEND                ///////////////////////////
    Route::post('/new_userb', 'UsuariosController@newUserBackend')->name('new_userb');
    Route::post('/saveUserb', 'UsuariosController@saveUserBackend')->name("saveUserb");
    Route::post('/changePassUB','UsuariosController@guardarCambioClaveUserb')->name("changePassUB");
    Route::post('/changeStatusUB','UsuariosController@guardarCambioEstatusUserb')->name("changeStatusUB");
    Route::post('/rebootPUB','UsuariosController@reiniciarClaveUserb')->name("rebootPUB");
    Route::post('/update_userb', 'UsuariosController@modalEditarUserBackend')->name('update_userb');
    Route::post('/modificarUserb', 'UsuariosController@updateUserBackend')->name("modificarUserb");

    //////////////////////////////////////////////////////////////////////////////////////////////// 
    ////////////////////////    START CATEGORIAS DIANA AJAX        ////////////////////////////////////
    Route::post('/consultas', 'Categoria\CategoriaController@consultas')->name('consultar');
    Route::post('/votacion', 'VotacionController@votando')->name("votacion");
    Route::post('/enviarContacto', 'VotacionController@contacto')->name("enviarContacto");
    Route::post('/admbanner', 'Frontend\FrontendController@consultas')->name('admbanner');
    Route::post('/activacbanner', 'Frontend\FrontendController@activaciones')->name('activacbanner');
    ////////////////////////    END CATEGORIAS DIANA AJAX       //////////////////////////////////////
});



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////        AUTENTICACIÓN POR REDES SOCIALES        ////////////////////////////////
Route::get('auth/{provider}', 'SocialLoginController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'SocialLoginController@handleProviderCallback');
