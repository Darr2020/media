<?php 

namespace App\Traits;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use App\Models\Config;
use App\Models\Publicidad;
use App\Models\TagXNoticia;
use App\Models\Tag;

trait NewsPageTrait {

    /**
     * Pagina de respuesta al infinite scroll de la pagina principal
     * @param Request $request
     * @param $page
     * @return Json $data
     */
    public function infiniteMainScroll(Request $request, $page)
    {

        if(!$request->ajax())
        {
            return redirect()->route('noticias_main');
        }

        #Todas las grillas
        $tot = collect(Config::getConfig(Config::GRIDS_APPROVED));
        $elements = collect(Config::getConfig(Config::ELEMENTS_APPROVED));
        $global = Config::getConfig(Config::MAIN);

        #Tomar todas las noticias en orden
        $noticias = Noticia::getPublished(true, $global->cantidad_maxima_principal);

        #Tomar todos los banners publicitarios en order de peso
        $banners = Publicidad::getOrder();

        #Obtener todas las noticias de la página a mostrar
        $print = $this->orderEverythingForMainPage($tot, $elements, $noticias, $banners, $page);

        return view('frontend.noticias.scroll-filter')->with(compact('print'));
    }

    /**
     * Pagina de respuesta al infinite scroll de la pagina de pruebas
     * @param Request $request
     * @param $page
     * @return Json $data
     */
    public function testScroll(Request $request, $page)
    {

        if(!$request->ajax())
        {
            return redirect()->route('noticias_test');
        }

        #Todas las grillas
        $tot = collect(Config::getConfig(Config::GRIDS));
        $elements = collect(Config::getConfig(Config::ELEMENTS));
        $global = Config::getConfig(Config::MAIN);

        #Tomar todas las noticias en orden
        $noticias = Noticia::getPublished(true, $global->cantidad_maxima_principal);

        #Tomar todos los banners publicitarios en order de peso
        $banners = Publicidad::getOrder();

        #Obtener todas las noticias de la página a mostrar
        $print = $this->orderEverythingForMainPage($tot, $elements, $noticias, $banners, $page);

        return view('frontend.noticias.scroll-filter')->with(compact('print'));
    }

    /**
     * Pagina de respuesta al infinite scroll de categoria
     * @param Request $request
     * @param $page
     * @param Categoria $id
     * @return Json $data
     */
    public function infiniteCategoryScroll(Request $request, $id, $page)
    {

        if(!$request->ajax())
        {
            return redirect()->route('categoria_individual', [
                'id' => $id
            ]);
        }

        #Todas las grillas
        $tot = collect(Config::getConfig(Config::GRIDS_APPROVED));
        $elements = collect(Config::getConfig(Config::ELEMENTS_APPROVED));
        $global = Config::getConfig(Config::MAIN);

        #Tomar todas las noticias en orden
        $noticias = Noticia::getPublishedByCategory($id,  true, $global->cantidad_maxima_categoria);

        #Tomar todos los banners publicitarios en order de peso
        $banners = Publicidad::getOrder();
        
        #Devuelve la organización de las grillas de cáda categoria
        $print = $this->orderEverythingForCategory($id, $tot, $elements, $noticias, $banners, $page);

        return view('frontend.noticias.scroll-filter')->with(compact('print'));
    }

}