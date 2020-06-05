@extends("backend.layout.layout")
@section("title", "MediaMétrica | Inicio")
@section('stylesheets')
@parent

@endsection
@section("body")

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">MediaMétrica</h5>
                <ol class="breadcrumbs">
                    <li><a href="">Inicio</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->
<!--start container-->
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="section">
                <div id="roboto">
                    <h4 class="header">Bienvenido a MediaMétrica</h4>
                    <div class="divider"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end container-->


@endsection
@section('javascripts')
@parent

@endsection
