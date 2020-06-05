$.ajaxSetup({
    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
});
$(document).ready(function () {

    $("#share-button").click(function (e) {
        e.preventDefault();
        $("#social-popover").animate({
            'top': '-150px',
            'opacity': '1',
        });
        setTimeout(function () {
            $("#social-popover").animate({
                'top': '0px',
                'opacity': '0',
            });
        }, 4000);
    });

    var viddd = $("#video").val();

    $("#rma").click(function () {
        $("#toprankingmedia").show();
        $("#toprankingcall").hide();
        $("#RankingM").show();
        $("#RankingC").hide();
        $("#imgweb").show();
        $("#imgtelf").hide();
        if (viddd == 1) {
            $('.vidtel')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            $('.vidweb')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
        }
        $("#InfomacioWeb").show();
        $("#InfomacioTelf").hide();
        $("#rtlf_zone").hide();
        $("#rweb_zone").show();
        $("#likegT").hide();
        $("#dislikegT").hide();
        $("#likeg").show();
        $("#dislikeg").show();
        $("#rweb_sinAuth").show();
        $("#rtlf_sinAuth").hide();

    });
    $("#rca").click(function () {
        $("#toprankingcall").show();
        $("#toprankingmedia").hide();
        $("#RankingC").show();
        $("#RankingM").hide();
        $("#imgweb").hide();
        $("#imgtelf").show();
        if (viddd == 1) {
            $('.vidweb')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            $('.vidtel')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
        }
        $("#InfomacioWeb").hide();
        $("#InfomacioTelf").show();
        $("#rtlf_zone").show();
        $("#rweb_zone").hide();

        $("#likegT").show();
        $("#dislikegT").show();
        $("#likeg").hide();
        $("#dislikeg").hide();
        $("#rtlf_sinAuth").show();
        $("#rweb_sinAuth").hide();


    });
    $("#rmi").click(function () {
        var cua = $("#cua").val();
        var cuaT = $("#cuaT").val();

        $("#toprankingmedia").show();
        $("#toprankingcall").hide();
        $("#RankingM").show();
        $("#RankingC").hide();
        $("#videotel").hide();
        $("#videoweb").show();
        $("#imgweb").show();
        $("#imgtelf").hide();
        if (viddd == 1) {
            $('.vidtel')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            $('.vidweb')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
        }
        $("#InfomacioWeb").show();
        $("#InfomacioTelf").hide();
        $("#rtlf_zone").hide();
        $("#rweb_zone").show();
        $("#likegT").hide();
        $("#dislikegT").hide();
        $("#likeg").show();
        $("#dislikeg").show();
        if (cua == 0) {
            $("#genericoT").hide();
            $("#meGustaT").hide();
        } else {
            $("#genericoT").show();
            $("#meGustaT").hide();
        }

        $("#rweb_sinAuth").show();
        $("#rtlf_sinAuth").hide();
    });
    $("#rci").click(function () {
        var cua = $("#cua").val();
        var cuaT = $("#cuaT").val();

        $("#toprankingcall").show();
        $("#toprankingmedia").hide();
        $("#RankingC").show();
        $("#RankingM").hide();
        $("#videotel").show();
        $("#videoweb").hide();
        $("#imgweb").hide();
        $("#imgtelf").show();
        if (viddd == 1) {
            $('.vidweb')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            $('.vidtel')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
        }
        $("#InfomacioWeb").hide();
        $("#InfomacioTelf").show();
        $("#rtlf_zone").show();
        $("#rweb_zone").hide();
        $("#likegT").show();
        $("#dislikegT").show();
        $("#likeg").hide();
        $("#dislikeg").hide();
        if (cuaT == 0) {
            $("#genericoT").hide();
            $("#meGustaT").hide();
        } else {
            $("#genericoT").show();
            $("#meGustaT").hide();
        }

        $("#rtlf_sinAuth").show();
        $("#rweb_sinAuth").hide();

    });
    $("#cerrarvideo").click(function () {
        $("#videowebprincipal").hide();
        $("#audiowebprincipal").hide();
        $("#videoweb").attr('src', " ");
        $("#audioweb").attr('src', " ");
    });
    $("#cerraraudio").click(function () {
        $("#videowebprincipal").hide();
        $("#audiowebprincipal").hide();
        $("#videoweb").attr('src', " ");
        $("#audioweb").attr('src', " ");
    });
    $("#cerraraudiodetalle").click(function () {
        $("#audiowebprincipal").hide();
        $("#audioweb").attr('src', " ");
    });
    $('.contacto').click(function () {
        var error = 0;
        var nombre = $('#nombrecontac').val();
        var correo = $('#email').val();
        var telefono = $('#telefono').val();
        var empresa = $('#empresa').val();
        var pais = $('#pais').val();
        var mensaje = $('#mensaje').val();
        var categoria_id = $('#categoria_id').val();

        if (nombre == "") {
            error++;
        }
        if (correo == "") {
            error++;
        }
        if (telefono == "") {
            error++;
        }
        if (empresa == "") {
            error++;
        }
        if (pais == "") {
            error++;
        }
        if (mensaje == "") {
            error++;
        }

        var form_data = new FormData();

        form_data.append("nombre", nombre);
        form_data.append("correo", correo);
        form_data.append("telefono", telefono);
        form_data.append("empresa", empresa);
        form_data.append("pais", pais);
        form_data.append("mensaje", mensaje);
        form_data.append("categoria_id", categoria_id);

        if (error === 0) {
            swal({
                title: 'Confirmación',
                text: 'Está seguro que quiere enviar esta información?',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: 'success',
                cancelButtonColor: 'danger',
                cancelButtonText: 'No',
                confirmButtonText: 'Si'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        "url": "/enviarContacto",
                        "data": form_data,
                        "dataType": 'json',
                        "cache": false,
                        "contentType": false,
                        "processData": false,
                        "type": "post",
                        success: function (data) {
                            if (data === 1) {
                                swal("Contacto MediaMetrica", "Se envio su información correctamente.", "success")
                                        .then(function () {
                                            location.reload();
                                        });
                            } else {
                                swal("No se pudo enviar la información, faltan datos por llenar, intente de nuevo.", "", "error");
                            }
                        },
                        error: function (data) {
                            swal("Error al guardar la información.", "", "error");
                        }
                    });
                }
            });
        } else {
            swal("Faltan datos por llenar, intente de nuevo.", "", "warning");
        }

    });
    String.prototype.capitalize = function () {
        // \b encuentra los limites de una palabra
        // \w solo los meta-carácter  [a-zA-Z0-9].                
        return this.toLowerCase().replace(/\b\w/g, function (m) {
            return m.toUpperCase();
        });
    };
    String.prototype.firstLetterUpper = function () {
        return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase();
    };
});

function verpagina(id) {

    var mapForm = document.createElement("form");
    mapForm.method = "POST";
    mapForm.action = "categoria_detalle";

    var mapInput1 = document.createElement("input");
    mapInput1.name = "id";
    mapInput1.value = id;
    var mapInput2 = document.createElement("input");
    mapInput2.name = "_token";
    mapInput2.value = $("meta[name=_token]").attr("content");

    mapForm.appendChild(mapInput1);
    mapForm.appendChild(mapInput2);
    document.body.appendChild(mapForm);
    mapForm.submit();
}

function videos(id, opt, encuesta_id, emotion, me_gusta, no_me_gusta, tipo_accion) {
    $("#audioweb").hide();
    $("#audioweb").attr('src', " ");
    $("#videoweb").val();
    $("#videotel").val();
    var id = id;
    var opt = opt;
    $.ajax({
        data: {id: id, encuesta_id: encuesta_id, opt: opt},
        url: "/buscarvideocand",
        type: 'POST',
        dataType: 'json',
        success: function (r) {
            if (r != false) {
                if (opt == 1) {
                    $("#videowebprincipal").show();
                    $("#audiowebprincipal").hide();
                    $("#InfomacioWeb").show();
                    $("#InfomacioTelf").hide();
                    $("#rtlf_zone").hide();
                    $("#rweb_zone").show();
                    $("#likeg").text(r.gusta);
                    $("#dislikeg").text(r.no_me_gusta);
                    $("#cua").val(1);

                    $("#nombre").text(r.nombre.capitalize());
                    $("#detalle").text(r.detalle.firstLetterUpper());
                    if (r.sexo != 0) {
                        if (r.sexo == 1) {
                            $("#sexo").text('Femenino');
                        } else if (r.sexo == 2) {
                            $("#sexo").text('Masculino');
                        } else if (r.sexo == 3) {
                            $("#sexo").text('Mixto');
                        }
                    }
                    if (r.pag != null) {
                        var pag = (r.pag).toLowerCase();
                    } else {
                        pag = '';
                    }
                    $("#pag").text(pag);
                    $("#seguidores").text(r.seguidores);
                    $("#generos").empty();
                    $("#redes").empty();
                    $.each(r.generos, function (i, c) {
                        if (c != null) {
                            var g = c.toLowerCase();
                            $("#generos").append(g + ' / ');
                        }
                    });
                    $.each(r.redes, function (i, c) {
                        if (c != null) {
                            var r = c.toLowerCase();
                            $("#redes").append(r + ' / ');
                        }
                    });
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                    if (tipo_accion == 1) {
                        $("#meGustaT").show();
                        $("#lvmore_selected").text(me_gusta);
                        $("#dvmore").text(no_me_gusta);

                        $("#genericoT").hide();
                        $("#first_load_RW").hide();

                        if (r.gusto_usuario == null) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").removeClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 1) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").addClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUpTM").addClass("emotion img_selected");
                            $("#likeUpTM").removeClass("emotion img_selected");
                        }
                    } else if (tipo_accion === undefined) {
                        $("#genericoT").show();
                        $("#meGustaT").hide();
                        $("#noMeGustaT").hide();
                        $("#first_load_RW").hide();
                        $("#genericoB").hide();

                        $("#like_sinauth").text(r.gusta);
                        $("#dislike_sinauth").text(r.no_me_gusta);

                        if (r.gusto_usuario == null) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").removeClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 1) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").addClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUp").addClass("emotion img_selected");
                            $("#likeUp").removeClass("emotion img_selected");
                        }
                    }
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                    $("#videoweb").attr('src', "https://www.youtube.com/embed/" + r.video + "?rel=0&enablejsapi=1&version=3&autoplay=1&playerapiid=ytplayer");
                } else if (opt == 2) {
                    $("#InfomacioWeb").hide();
                    $("#InfomacioTelf").show();
                    $("#rtlf_zone").show();
                    $("#rweb_zone").hide();
                    $("#nombret").text(r.nombre.capitalize());
                    $("#detallet").text(r.detalle.firstLetterUpper());
                    $("#likegT").text(r.gusta);
                    $("#dislikegT").text(r.no_me_gusta);
                    $("#cuaT").val(1);

                    if (r.sexo != 0) {
                        if (r.sexo == 1) {
                            $("#sexot").text('Femenino');
                        } else if (r.sexo == 2) {
                            $("#sexot").text('Masculino');
                        } else if (r.sexo == 3) {
                            $("#sexot").text('Mixto');
                        }
                    }
                    if (r.pag != null) {
                        var pag = (r.pag).toLowerCase();
                    } else {
                        pag = '';
                    }
                    $("#pagt").text(pag);
                    $("#seguidorest").text(r.seguidores);
                    $("#generost").empty();
                    $("#redest").empty();
                    $.each(r.generos, function (i, c) {
                        if (c != null) {
                            var g = c.toLowerCase();
                            $("#generost").append(g + ' / ');
                        }
                    });
                    $.each(r.redes, function (i, c) {
                        if (c != null) {
                            var r = c.toLowerCase();
                            $("#redest").append(r + ' / ');
                        }
                    });
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                    if (tipo_accion == 1) {
                        $("#meGustaT").show();
                        $("#lvmore_selected").text(me_gusta);
                        $("#dvmore").text(no_me_gusta);

                        $("#genericoT").hide();
                        $("#first_load_RT").hide();
                        if (r.gusto_usuario == null) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").removeClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 1) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").addClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUpTM").addClass("emotion img_selected");
                            $("#likeUpTM").removeClass("emotion img_selected");
                        }
                    } else if (tipo_accion === undefined) {
                        $("#genericoT").show();
                        $("#meGustaT").hide();
                        $("#noMeGustaT").hide();
                        $("#first_load_RT").hide();
                        $("#genericoBRT").hide();


                        $("#like_sinauthRT").text(r.gusta);
                        $("#dislike_sinauthRT").text(r.no_me_gusta);
                        if (r.gusto_usuario == null) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").removeClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");

                        }
                        if (r.gusto_usuario == 1) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").addClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 2 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUp").addClass("emotion img_selected");
                            $("#likeUp").removeClass("emotion img_selected");
                        }
                    }
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                    $("#videotel").attr('src', "https://www.youtube.com/embed/" + r.video + "?rel=0&enablejsapi=1&version=3&autoplay=1&playerapiid=ytplayer");
                } else if (opt == 3) {
                    $("#InfomacioWeb").show();
                    $("#InfomacioTelf").hide();
                    $("#rtlf_zone").hide();
                    $("#rweb_zone").show();
                    $("#nombre").text(r.nombre.capitalize());
                    $("#detalle").text(r.detalle.firstLetterUpper());
                    $("#likeg").text(r.gusta);
                    $("#dislikeg").text(r.no_me_gusta);
                    $("#cua").val(1);

                    if (r.sexo != 0) {
                        if (r.sexo == 1) {
                            $("#sexo").text('Femenino');
                        } else if (r.sexo == 2) {
                            $("#sexo").text('Masculino');
                        } else if (r.sexo == 3) {
                            $("#sexo").text('Mixto');
                        }
                    }
                    if (r.pag != null) {
                        var pag = (r.pag).toLowerCase();
                    } else {
                        pag = '';
                    }
                    $("#pag").text(pag);
                    $("#seguidores").text(r.seguidores);
                    $("#generos").empty();
                    $("#redes").empty();
                    $.each(r.generos, function (i, c) {
                        if (c != null) {
                            var g = c.toLowerCase();
                            $("#generos").append(g + ' / ');
                        }
                    });
                    $.each(r.redes, function (i, c) {
                        if (c != null) {
                            var r = c.toLowerCase();
                            $("#redes").append(r + ' / ');
                        }
                    });
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                    if (tipo_accion == 1) {
                        $("#meGustaT").show();
                        $("#lvmore_selected").text(me_gusta);
                        $("#dvmore").text(no_me_gusta);

                        $("#genericoT").hide();
                        $("#first_load_RW").hide();

                        if (r.gusto_usuario == null) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").removeClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 1) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").addClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUpTM").addClass("emotion img_selected");
                            $("#likeUpTM").removeClass("emotion img_selected");
                        }
                    } else if (tipo_accion === undefined) {
                        $("#genericoT").show();
                        $("#meGustaT").hide();
                        $("#noMeGustaT").hide();
                        $("#first_load_RW").hide();
                        $("#genericoB").hide();

                        $("#like_sinauth").text(r.gusta);
                        $("#dislike_sinauth").text(r.no_me_gusta);
                        if (r.gusto_usuario == null) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").removeClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 1) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").addClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUp").addClass("emotion img_selected");
                            $("#likeUp").removeClass("emotion img_selected");
                        }
                    }
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

                    $("#imgweb").show();
                    $("#imgweb").attr('src', "http://localhost:8000/candidatos/images/" + r.img + "");
                    $("#imgtelf").hide();
                } else if (opt == 4) {
                    $("#InfomacioWeb").hide();
                    $("#InfomacioTelf").show();
                    $("#rtlf_zone").show();
                    $("#rweb_zone").hide();
                    $("#nombret").text(r.nombre.capitalize());
                    $("#detallet").text(r.detalle.firstLetterUpper());
                    $("#likegT").text(r.gusta);
                    $("#dislikegT").text(r.no_me_gusta);
                    $("#cuaT").val(1);

                    if (r.sexo != 0) {
                        if (r.sexo == 1) {
                            $("#sexot").text('Femenino');
                        } else if (r.sexo == 2) {
                            $("#sexot").text('Masculino');
                        } else if (r.sexo == 3) {
                            $("#sexot").text('Mixto');
                        }
                    }
                    if (r.pag != null) {
                        var pag = (r.pag).toLowerCase();
                    } else {
                        pag = '';
                    }
                    $("#pagt").text(pag);
                    $("#seguidorest").text(r.seguidores);
                    $("#generost").empty();
                    $("#redest").empty();
                    $.each(r.generos, function (i, c) {
                        if (c != null) {
                            var g = c.toLowerCase();
                            $("#generost").append(g + ' / ');
                        }
                    });
                    $.each(r.redes, function (i, c) {
                        if (c != null) {
                            var r = c.toLowerCase();
                            $("#redest").append(r + ' / ');
                        }
                    });

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
                    if (tipo_accion == 1) {
                        $("#meGustaT").show();
                        $("#lvmore_selected").text(me_gusta);
                        $("#dvmore").text(no_me_gusta);

                        $("#genericoT").hide();
                        $("#first_load_RT").hide();

                        if (r.gusto_usuario == null) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").removeClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");

                        }
                        if (r.gusto_usuario == 1) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUpTM").addClass("emotion img_selected");
                            $("#dislikeUpTM").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likeb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#dislb").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUpTM").addClass("emotion img_selected");
                            $("#likeUpTM").removeClass("emotion img_selected");
                        }

                    } else if (tipo_accion === undefined) {
                        $("#genericoT").show();
                        $("#meGustaT").hide();
                        $("#noMeGustaT").hide();
                        $("#first_load_RT").hide();
                        $("#genericoBRT").hide();

                        $("#like_sinauthRT").text(r.gusta);
                        $("#dislike_sinauthRT").text(r.no_me_gusta);

                        if (r.gusto_usuario == null) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").removeClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 1) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#likeUp").addClass("emotion img_selected");
                            $("#dislikeUp").removeClass("emotion img_selected");
                        }
                        if (r.gusto_usuario == 2) {
                            $("#likea").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 1 + ',' + opt + ')');
                            $("#disla").attr('onclick', 'feel(' + encuesta_id + ',' + r.categoria_id + ',' + r.candidato_multimedia_id + ',' + id + ',' + 1 + ',' + 2 + ',' + opt + ')');

                            $("#dislikeUp").addClass("emotion img_selected");
                            $("#likeUp").removeClass("emotion img_selected");
                        }
                    }
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

                    $("#imgtelf").show();
                    $("#imgtelf").attr('src', "http://localhost:8000/candidatos/images/" + r.img + "");
                    $("#imgweb").hide();
                }
            } else {
                $("#videoweb").show();
                $("#audiowebprincipal").hide();
                $("#videowebprincipal").hide();
            }

        }
    });
}


function audios(id, opt) {
    var id = id;
    var opt = opt;
    $.ajax({
        data: {id: id},
        url: "/buscaraudio",
        type: 'POST',
        dataType: 'json',
        success: function (r) {
            if (r != false) {
                if (opt == 1) {
                    $("#audioweb").show();
                    $("#videoweb").attr('src', " ");
                    $("#audiowebprincipal").show();
                    $("#videowebprincipal").hide();
                    $("#tituloaudio").text(r[0].nombre);
                    $("#audioweb").attr('src', "http://localhost:8000/candidatos/audio/" + r[0].audio + "");
                } else if (opt == 2) {
                    $("#audioweb").show();
                    $("#audiowebprincipal").show();
                    $("#videowebprincipal").show();
                    $("#audioweb").attr('src', "http://localhost:8000/candidatos/audio/" + r[0].audio + "");
                    $('.vidweb')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                    $('.vidtel')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                }
            } else {
                $("#audioweb").show();
                $("#audiowebprincipal").hide();
                $("#videowebprincipal").hide();
            }
        }
    });
}
function voto(id, opt, enc) {

    swal({
        title: 'Confirmación',
        text: "Está seguro que desea votar por este Candidato en esta Categoria?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        confirmButtonText: 'Si'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                "url": "/votacion",
                "data": {id: id, opt: opt, enc: enc},
                "type": "post",
                "error": function () {
                    swal("Error inesperado", "", "warning");
                },
                "success": function (resp) {
                    if (resp == 1) {
                        location.reload();
                    } else if (resp == 2) {
                        swal("Ha ocurrido un problema, intente de nuevo", "", "error");
                    }
                }
            });
        }
    });
}