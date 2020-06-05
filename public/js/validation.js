$(document).ready(function () {

    $.ajaxSetup({
        headers: {"X-CSRF-Token": $("meta[name=_token]").attr("content")}
    });

    var _URL = window.URL || window.webkitURL;
    //funcion para bloquear campos solo letras o solo numeros
    (function (a) {
        a.fn.validCampo = function (b) {
            a(this).on({keypress: function (a) {
                    var c = a.which, d = a.keyCode, e = String.fromCharCode(c).toLowerCase(), f = b;
                    (-1 != f.indexOf(e) || 9 == d || 37 != c && 37 == d || 39 == d && 39 != c || 8 == d || 46 == d && 46 != c) && 161 != c || a.preventDefault()
                }})
        }
    })(jQuery);
    $('#seg').validCampo('0123456789.');
    $('#segg').validCampo('0123456789.');
    //fin funcion para bloquear campos solo letras o solo numeros
    $('.tooltipped').tooltip({delay: 50});
    $('select').material_select();
    $("input:checkbox").prop("checked", false);
    $('input:radio[id=nombre]').prop('checked', true);
    $('input:radio[id=img]').prop('checked', true);
    $("#generoArt").change(function () {
        $("#genArt").toggle();
        $(".genr").remove();
        $("#agregar").toggle();
        $("#eliminargenArt").toggle();
        campo = '<input type="text" class="genr" id="generosArt" name="generosArt[' + 0 + ']" />';
        $("#campos").append(campo);
    });
    var nextinput = 0;
    $('#agregar').click(function () {
        nextinput++;
        campo = '<input type="text" class="genr" id="generosArt" name="generosArt[' + nextinput + ']"/>';
        $("#campos").append(campo);
        $('#contador').val(nextinput);
    });
    $('#agregarRedes').click(function () {
        nextinput++;
        camposgen = '<input type="text" class="redessocc" id="redess' + nextinput + '" name="redess"/>';
        $("#camposgenn").append(camposgen);
        $('#contador').val(nextinput);
    });
    $('#eliminarRedes').click(function () {
        if (nextinput != 0) {
            $('#redess' + nextinput).remove();
            nextinput = nextinput - 1;
        }
    });
    $('#eliminargenArt').click(function () {
        if (nextinput != 0) {
            $('input[name="generosArt[' + nextinput + ']"]').remove();
            nextinput = nextinput - 1;
        }
    });

    var generosart = $('.genr').toArray().some(function (el) {
        return $(el).val().length < 1;
    });
    if (generosart) {
        swal("Faltan Géneros por completar", "warning");
    }

    $('#imggg').change(function () {

        var file = $('#imggg')[0].files[0];
        img = new Image();
        var imgwidth = 0;
        var imgheight = 0;
        var minwidth = 1200;
        var minheight = 700;
        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            imgwidth = this.width;
            imgheight = this.height;
            if (imgwidth <= minwidth && imgheight <= minheight) {
                swal("La imagen debe ser " + minwidth + "px de ancho por " + minheight + "px de alto", "", "warning");
            }
        };
        img.onerror = function () {
            swal("El archivo adjunto no es valido para una imagen es un: " + file.type, "", "warning");
        };
    });

    $('.collapsible').collapsible();

});

function solonumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function sololetras(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8 || tecla == 32) {
        return true;
    }
    patron = /[A-Za-z]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function dt() {

    $("#datos").show();
    $("#campos").hide();
    $("#generos").hide();
    $("#d").removeClass("col s12 m1 l1");
    $("#d").addClass("col s12 m8 l8");
    $("#g").removeClass("col s12 m8 l8");
    $("#g").addClass("col s12 m1 l1");
    $("#c").removeClass("col s12 m8 l8");
    $("#c").addClass("col s12 m1 l1");
    /*candidato*/
    $("#datoscand").show();
    $("#generoscand").hide();
    $("#redescand").hide();
    $("#multicand").hide();
    $("#d").removeClass("col s12 m1 l1");
    $("#d").addClass("col s12 m8 l8");
    $("#g").removeClass("col s12 m8 l8");
    $("#g").addClass("col s12 m1 l1");
    $("#c").removeClass("col s12 m8 l8");
    $("#c").addClass("col s12 m1 l1");
    $("#m").removeClass("col s12 m8 l8");
    $("#m").addClass("col s12 m1 l1");
}

function op() {

    $("#campos").show();
    $("#datos").hide();
    $("#generos").hide();
    $("#c").removeClass("col s12 m1 l1");
    $("#c").addClass("col s12 m8 l8");
    $("#d").removeClass("col s12 m8 l8");
    $("#d").addClass("col s12 m1 l1");
    $("#g").removeClass("col s12 m8 l8");
    $("#g").addClass("col s12 m1 l1");
    /*candidato*/
    $("#datoscand").hide();
    $("#generoscand").hide();
    $("#redescand").show();
    $("#multicand").hide();
    $("#d").removeClass("col s12 m8 l8");
    $("#d").addClass("col s12 m1 l1");
    $("#g").removeClass("col s12 m8 l8");
    $("#g").addClass("col s12 m1 l1");
    $("#c").removeClass("col s12 m1 l1");
    $("#c").addClass("col s12 m8 l8");
    $("#m").removeClass("col s12 m8 l8");
    $("#m").addClass("col s12 m1 l1");
}
function gen() {

    $("#generos").show();
    $("#campos").hide();
    $("#datos").hide();
    $("#g").removeClass("col s12 m1 l1");
    $("#g").addClass("col s12 m8 l8");
    $("#c").removeClass("col s12 m8 l8");
    $("#c").addClass("col s12 m1 l1");
    $("#d").removeClass("col s12 m8 l8");
    $("#d").addClass("col s12 m1 l1");
    /*candidato*/
    $("#datoscand").hide();
    $("#generoscand").show();
    $("#redescand").hide();
    $("#multicand").hide();
    $("#d").removeClass("col s12 m8 l8");
    $("#d").addClass("col s12 m1 l1");
    $("#g").removeClass("col s12 m1 l1");
    $("#g").addClass("col s12 m8 l8");
    $("#c").removeClass("col s12 m8 l8");
    $("#c").addClass("col s12 m1 l1");
    $("#m").removeClass("col s12 m8 l8");
    $("#m").addClass("col s12 m1 l1");

}
function mul() {

    /*candidato*/
    $("#datoscand").hide();
    $("#generoscand").hide();
    $("#redescand").hide();
    $("#multicand").show();
    $("#d").removeClass("col s12 m8 l8");
    $("#d").addClass("col s12 m1 l1");
    $("#m").removeClass("col s12 m1 l1");
    $("#m").addClass("col s12 m8 l8");
    $("#c").removeClass("col s12 m8 l8");
    $("#c").addClass("col s12 m1 l1");
    $("#g").removeClass("col s12 m8 l8");
    $("#g").addClass("col s12 m1 l1");

}

function agregar() {

    var nextinput = $("#agrnext").val();
    nextinput++;
    camposed = '<input type="text" class="genr" id="generosArt' + nextinput + '" name="generosArt[' + nextinput + ']"/>';

    $("#camposed").append(camposed);
    $('#agrnext').val(nextinput);
}

function eliminarGenArt() {

    var nextinput = $("#agrnext").val();
    if (nextinput != 0) {
        $('#generosArt' + nextinput).remove();
        nextinput = nextinput - 1;
        $('#agrnext').val(nextinput);
    }
}

function agregarredes() {

    var nextinput = $("#agrnext").val();
    nextinput++;
    camposed = '<input type="text" class="redessoc" id="redes[' + nextinput + ']" name="redes"/>';

    $("#camposgen").append(camposed);
    $('#agrnext').val(nextinput);
}

function eliminarredes() {

    var nextinput = $("#agrnext").val();
    if (nextinput != 0) {
        $('input[id="redes[' + nextinput + ']"]').remove();
        nextinput = nextinput - 1;
        $('#agrnext').val(nextinput);
    }
}

function cambioimg() {

    var _URL = window.URL || window.webkitURL;
    var file = $('#imgg')[0].files[0];
    img = new Image();
    var imgwidth = 0;
    var imgheight = 0;
    var minwidth = 1200;
    var minheight = 700;
    img.src = _URL.createObjectURL(file);
    file.onload = function () {
        imgwidth = this.width;
        imgheight = this.height;
        if (imgwidth <= minwidth && imgheight <= minheight) {
            swal("La imagen debe ser " + minwidth + "px de ancho por " + minheight + "px de alto", "", "warning");
        }
    };
    img.onerror = function () {
        swal("El archivo adjunto no es valido para una imagen es un: " + file.type, "", "warning");
    };
}

function hgenart() {

    var a = 0;
    var gener = $("#gener").val();
    var agrnext = $("#agrnext").val();

    if (gener == 1) {
        if ($('input:checkbox[name=generoArt]').is(":checked")) {
            $("#genero").show();
        } else {
            swal({
                title: 'Confirmación',
                text: 'Está seguro que quiere elminar los generos creados?',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: 'success',
                cancelButtonColor: 'danger',
                cancelButtonText: 'No',
                confirmButtonText: 'Si'
            }).then(function (result) {
                if (result.value) {
                    for (a = 1; a < agrnext; a++) {
                        $('#generosArt' + a).remove();
                    }
                    $('#generosArt' + 0).val('');
                    $('#agrnext').val(0);
                    $("#genero").remove();
                    $("#gener").val(0)
                } else {
                    $("#genero").show();
                    $('input:checkbox[name=generoArt]').prop('checked', true);
                }
            });
        }
    } else {
        if ($('input:checkbox[name=generoArt]').is(":checked")) {
            $("#generosnuevos").show();
        } else {
            $("#generosnuevos").hide();
        }
    }
}
