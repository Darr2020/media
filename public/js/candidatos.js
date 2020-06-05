$.ajaxSetup({
    headers: {"X-CSRF-Token": $("meta[name=_token]").attr("content")}
});
$(document).ready(function () {
    var _URL = window.URL || window.webkitURL;

    $('#guardar').click(function () {
        var error = 0;
        var svcat = $("#svcat").serialize();
        var nomCatg = $('#nomCatg').val();
        var desCateg = $('#desCateg').val();
        var desCand = $('#desCand').val();
        var generosart = $('.genr').toArray().some(function (el) {
            return $(el).val().length < 1;
        });
        if (nomCatg == "") {
            error++;
        }
        if (desCateg == "") {
            error++;
        }
        if (desCand == "") {
            error++;
        }
        if ($("#generoArt").is(':checked')) {
            if (generosart) {
                swal("Faltan Generos por completar, intente de nuevo.", "", "warning");
                error++;
            }
        }

        if (error === 0) {
            swal({
                title: 'Confirmación',
                text: 'Está seguro que quiere crear esta categoria?',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: 'success',
                cancelButtonColor: 'danger',
                cancelButtonText: 'No',
                confirmButtonText: 'Si'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: "crearCategoria",
                        type: "post",
                        data: "svcat=" + svcat,
                        success: function (data) {
                            if (data === 1) {
                                swal("Categoria Creada", "Se creo la categoria correctamente.", "success")
                                        .then(function () {
                                            location.href = 'categoria';
                                        });
                            } else {
                                swal("No se pudo crear la categoria, faltan datos por llenar, intente de nuevo.", "", "error");
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

    $('#guardarcand').click(function (e) {
        e.preventDefault();
        var error = 0;
        var nombre = $('#nombree').val();
        var infor = $('#inforr').val();
        var imgm = $('#imggg').val();
        var aud = $('#audd').val();
        var video = $('#videoo').val();
        var pag = $('#pagg').val();
        var cia = $('#ciaa').val();
        var seg = $('#segg').val();
        var generopersona = $("input[name=gen]:checked").next().text();
        var a = 0;
        var b = 0;
        var generoper = 0;
        var generosasrtValues = Array();
        var redesValues = Array();
        var redes = $('.redessocc').toArray().some(function (el) {
            return $(el).val().length < 1;
        });

        if (generopersona === 'Femenino') {
            generoper = 1;
        } else if (generopersona === 'Masculino') {
            generoper = 2;
        } else if (generopersona === 'Mixto') {
            generoper = 3;
        }
        if (redes) {
            error++;
        }
        $('input:checkbox[class=gennnn]').each(function () {
            if ($(this).is(':checked')) {
                generosasrtValues.push($(this).val());
                a++;
            }
        });
        $('input:radio[name=gen]').each(function () {
            if ($(this).is(':checked')) {
                b++;
            }
        });
        $('input[class=redessocc]').toArray().some(function (el) {
            if ($(el).val().length > 1) {
                redesValues.push($(el).val());
            }
        });
        if ($('#nombree').is(":visible")) {
            if (nombre === "") {
                $("#nombree").focus();
                $("#nombree").addClass("yellow lighten-4");
                error++;
            } else {
                $("#nombree").removeClass("yellow lighten-4");
            }
        }
        if ($('#inforr').is(":visible")) {
            if (infor === "") {
                $("#inforr").focus();
                $("#inforr").addClass("yellow lighten-4");
                error++;
            } else {
                $("#inforr").removeClass("yellow lighten-4");
            }
        }
        if ($('input:radio[name=gen]').is(":visible")) {
            if (b === 0) {
                $('#3').focus();
                $("#3").addClass("yellow lighten-4");
                error++;
            } else {
                $("#3").removeClass("yellow lighten-4");
            }
        }
        if ($('input:checkbox[class=gennnn]').is(":visible")) {
            if (a === 0) {
                $("#4").focus();
                $("#4").addClass("yellow lighten-4");
                error++;
            } else {
                $("#4").removeClass("yellow lighten-4");
            }
        }
        if ($('#audd').is(":visible")) {
            var exaudio = aud.substring(aud.lastIndexOf("."));
            var aud = $('#audd').get(0).files[0];
            if (aud === "") {
                $("#audd").focus();
                $("#audd").addClass("yellow lighten-4");
                error++;
            } else {
                if (exaudio !== ".mp3") {
                    swal("El archivo de tipo " + exaudio + " no es válido, debe ser .mp3", "", "warning");
                    $("#audd").focus();
                    $("#audd").addClass("yellow lighten-4");
                    error++;
                } else {
                    $("#audd").removeClass("yellow lighten-4");
                }
            }
        } else {
            aud = 0;
        }
        if ($('#videoo').is(":visible")) {
            if (video === "") {
                $("#videoo").focus();
                $("#videoo").addClass("yellow lighten-4");
                error++;
            } else {
                $("#videoo").removeClass("yellow lighten-4");
            }
        }
        if ($('#pagg').is(":visible")) {
            if (pag === "") {
                $("#pagg").focus();
                $("#pagg").addClass("yellow lighten-4");
                error++;
            } else {
                $("#pagg").removeClass("yellow lighten-4");
            }
        }
        if ($('#ciaa').is(":visible")) {
            if (cia === "") {
                $("#ciaa").focus();
                $("#ciaa").addClass("yellow lighten-4");
                error++;
            } else {
                $("#ciaa").removeClass("yellow lighten-4");
            }
        }
        if ($('#segg').is(":visible")) {
            if (seg === "") {
                $("#segg").focus();
                $("#segg").addClass("yellow lighten-4");
                error++;
            } else {
                $("#segg").removeClass("yellow lighten-4");
            }
        }
        if ($('#imggg').is(":visible")) {

            var imgg = $('#imggg').get(0).files[0];
            if (imgm === "") {
                $("#imgg").focus();
                $("#5").addClass("yellow lighten-4");
                error++;
            } else {
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
                $("#5").removeClass("yellow lighten-4");
            }
        } else {
            imgg = 0;
        }
        if ($('.redessocc').is(":visible")) {
            if (redes === true) {
                $('#8').focus();
                $("#8").addClass("yellow lighten-4");
                error++;
            } else {
                $("#8").removeClass("yellow lighten-4");
            }
        }

        var form_data = new FormData();

        form_data.append("aud", aud);
        form_data.append("imgg", imgg);
        form_data.append("nombre", $('#nombree').val());
        form_data.append("infor", $('#inforr').val());
        form_data.append("video", $('#videoo').val());
        form_data.append("pag", $('#pagg').val());
        form_data.append("cia", $('#ciaa').val());
        form_data.append("seg", $('#segg').val());
        form_data.append("categ", $('#categ').val());
        form_data.append("tipo", 1);
        form_data.append("gen", generoper);
        $.each($('input:checkbox[class=gennnn]'), function () {
            if ($(this).is(':checked')) {
                form_data.append("generoArt[]", $(this).val());
                a++;
            }
        });
        $('input[class=redessocc]').toArray().some(function (el) {
            if ($(el).val().length > 1) {
                form_data.append("redes[]", $(el).val());
            }
        });
        if (error === 0) {
            swal({
                title: 'Confirmación',
                text: 'Está seguro que quiere crear este candidato?',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: 'success',
                cancelButtonColor: 'danger',
                cancelButtonText: 'No',
                confirmButtonText: 'Si'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        "url": "crearCandidato",
                        "data": form_data,
                        "dataType": 'json',
                        "cache": false,
                        "contentType": false,
                        "processData": false,
                        "type": "post",
                        success: function (data) {
                            if (data === 1) {
                                swal("Candidato Creado", "Se guardo la información correctamente.", "success")
                                        .then(function () {
                                            location.href = 'area';
                                        });
                            } else if (data === 2) {
                                swal("No se ingreso ningun nombre de candidato, intente de nuevo.", "", "error");
                            } else if (data === 3) {
                                swal("No se pudo guardar la imagen en la carpeta, intente de nuevo.", "", "error");
                            } else if (data === 4) {
                                swal("Error de formato en la imagen debe ser 'image/jpeg' 'image/jpg' 'image/png' 'image/gif', intente de nuevo.", "", "error");
                            } else if (data === 5) {
                                swal("No se pudo guardar el audio en la carpeta, intente de nuevo.", "", "error");
                            } else if (data === 6) {
                                swal("Error de formato en el audio debe ser 'audio/mpeg' 'audio/mp3' 'application/octet-stream', intente de nuevo.", "", "error");
                            } else if (data === 7) {
                                swal("No se guardo la informacion en base de datos, intente de nuevo.", "", "error");
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
});

function confirmar(id, opt, valor) {

    var texto;
    var mensaje;

    if (opt === 1) {
        texto = "Está seguro que desea inactivar esta categoria?, se inactivaran todos los Candidatos de esta Categoria";
        mensaje = "Inactivación exitosa.";
    } else if (opt === 2) {
        texto = "Está seguro que desea activar esta categoria?, se activaran todos los Candidatos de esta Categoria";
        mensaje = "La activación se realizó con éxito";
    } else if (opt === 5) {
        var texto = "Está seguro que desea inactivar este candidato?";
        var mensaje = "Inactivación exitosa.";
    } else if (opt === 6) {
        texto = "Está seguro que desea activar este candidato?";
        mensaje = "La activación se realizó con éxito";
    }
    swal({
        title: 'Confirmación',
        text: texto,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        confirmButtonText: 'Si'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                "url": "activaciones",
                "data": {id: id, opt: opt, estatus: valor},
                "type": "post",
                "error": function () {
                    swal("Error inesperado", "", "warning");
                },
                "success": function (resp) {
                    if (resp == 1) {
                        swal(mensaje, "", "success")
                                .then(function () {
                                    location.reload();
                                });
                    } else if (resp == 2) {
                        swal("Ha ocurrido un problema, intente de nuevo", "", "error");
                    }
                }
            });
        }
    });
}

function editarCandidato(moom) {

    var error = 0;
    var _URL = window.URL || window.webkitURL;
    var moom = moom;
    var a1 = $('#a1').val();
    var a2 = $('#a2').val();
    var a3 = $('#a3').val();
    var a4 = $('#a4').val();
    var infor = $('#infor').val();
    var imgm = $('#imgg').val();
    var aud = $('#aud').val();
    var video = $('#video').val();
    var pag = $('#pag').val();
    var cia = $('#cia').val();
    var seg = $('#seg').val();
    var generopersona = $("input[name=gen]:checked").next().text();
    var a = 0;
    var b = 0;
    var generosasrtValues = Array();
    var redesValues = Array();
    var redes = $('.redessoc').toArray().some(function (el) {
        return $(el).val().length < 1;
    });

    var form_data = new FormData();

    if (generopersona === 'Femenino') {
        generopersona = 1;
    } else if (generopersona === 'Masculino') {
        generopersona = 2;
    } else if (generopersona === 'Mixto') {
        generopersona = 3;
    }
    if (redes) {
        error++;
    }
    $('input:checkbox[class=gennnn]').each(function () {
        if ($(this).is(':checked')) {
            generosasrtValues.push($(this).val());
            a++;
        }
    });
    $('input:radio[name=gen]').each(function () {
        if ($(this).is(':checked')) {
            b++;
        }
    });
    $('input[class=redessoc]').toArray().some(function (el) {
        if ($(el).val().length > 1) {
            redesValues.push($(el).val());
        }
    });

    if (moom == 1) {

        if ($('#infor').is(":visible")) {
            if (infor === "") {
                $("#infor").focus();
                $("#infor").addClass("yellow lighten-4");
                error++;
            } else {
                $("#infor").removeClass("yellow lighten-4");
            }
            form_data.append("infor", infor);
        }
        if ($('input:radio[name=gen]').is(":visible")) {
            if (b === 0) {
                $('#3').focus();
                $("#3").addClass("yellow lighten-4");
                error++;
            } else {
                $("#3").removeClass("yellow lighten-4");
            }
            form_data.append("gen", generopersona);
        }

    } else if (moom == 2) {

        if ($('input:checkbox[class=gennnn]').is(":visible")) {
            if (a === 0) {
                $("#4").focus();
                $("#4").addClass("yellow lighten-4");
                error++;
            } else {
                $("#4").removeClass("yellow lighten-4");
            }
            $.each($('input:checkbox[class=gennnn]'), function () {
                if ($(this).is(':checked')) {
                    form_data.append("generoArt[]", $(this).val());
                    a++;
                }
            });
        }


    } else if (moom == 3) {

        if ($('#pag').is(":visible")) {
            if (pag === "") {
                $("#pag").focus();
                $("#pag").addClass("yellow lighten-4");
                error++;
            } else {
                $("#pag").removeClass("yellow lighten-4");
            }
            form_data.append("pag", pag);
        } else {
            pag = '';
        }
        if ($('#seg').is(":visible")) {
            if (seg === "") {
                $("#seg").focus();
                $("#seg").addClass("yellow lighten-4");
                error++;
            } else {
                $("#seg").removeClass("yellow lighten-4");
            }
            form_data.append("seg", seg);
        } else {
            seg = '';
        }
        if ($('.redessoc').is(":visible")) {
            if (redes === true) {
                $('#8').focus();
                $("#8").addClass("yellow lighten-4");
                error++;
            } else {
                $("#8").removeClass("yellow lighten-4");
            }
            $('input[class=redessoc]').toArray().some(function (el) {
                if ($(el).val().length > 1) {
                    form_data.append("redes[]", $(el).val());
                }
            });
        }

    } else if (moom == 4) {

        if ($('#cia').is(":visible")) {
            if (cia === "") {
                $("#cia").focus();
                $("#cia").addClass("yellow lighten-4");
                error++;
            } else {
                $("#cia").removeClass("yellow lighten-4");
            }
            form_data.append("cia", cia);
        } else {
            cia = '';
        }
        if ($('#imgg').is(":visible")) {

            var imgg = $('#imgg').get(0).files[0];
            if (imgm === "") {
                $("#imgg").focus();
                $("#5").addClass("yellow lighten-4");
                error++;
            } else {
                var file = $('#imgg')[0].files[0];
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
                $("#5").removeClass("yellow lighten-4");
            }
            form_data.append("imgg", imgg);
        } else {
            imgg = 0;
        }
        if ($('#aud').is(":visible")) {
            var exaudio = aud.substring(aud.lastIndexOf("."));
            var aud = $('#aud').get(0).files[0];
            if (aud === "") {
                $("#aud").focus();
                $("#aud").addClass("yellow lighten-4");
                error++;
            } else {
                if (exaudio !== ".mp3") {
                    swal("El archivo de tipo " + exaudio + " no es válido, debe ser .mp3", "", "warning");
                    $("#aud").focus();
                    $("#aud").addClass("yellow lighten-4");
                    error++;
                } else {
                    $("#aud").removeClass("yellow lighten-4");
                }
            }
            form_data.append("aud", aud);
        } else {
            aud = 0;
        }
        if ($('#video').is(":visible")) {
            if (video === "") {
                $("#video").focus();
                $("#video").addClass("yellow lighten-4");
                error++;
            } else {
                $("#video").removeClass("yellow lighten-4");
            }
            form_data.append("video", video);
        } else {
            video = '';
        }

    }

    form_data.append("categ", $('#categ').val());
    form_data.append("cand_id", $('#cand_id').val());
    form_data.append("tipo", 2);
    form_data.append("moom", moom);
    form_data.append("nombre", 'actualizar');

    if (error === 0) {
        swal({
            title: 'Confirmación',
            text: 'Está seguro que quiere actualizar este candidato?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: 'success',
            cancelButtonColor: 'error',
            cancelButtonText: 'No',
            confirmButtonText: 'Si'
        }).then(function (result) {
            if (result.value) {
                swal({
                    title: 'Actualización de Candidato',
                    html: '<b>Está seguro que quiere actualizar este candidato?<br></b><font color="red" size="4"> La información anterior sera inactivada y se actualizará con los datos cargados en este formulario.</font><br><br>',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'success',
                    cancelButtonColor: 'red',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Si'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            "url": "crearCandidato",
                            "data": form_data,
                            "dataType": 'json',
                            "cache": false,
                            "contentType": false,
                            "processData": false,
                            "type": "post",
                            success: function (data) {
                                if (data === 1) {
                                    if (moom == 1) {
                                        if (a2 == 2) {
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
                                        } else if (a3 == 3) {
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
                                        } else if (a4 == 4) {
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
                                    } else if (moom == 2) {
                                        if (a3 == 3) {
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
                                        } else if (a4 == 4) {
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
                                    } else if (moom == 3) {
                                        if (a4 == 4) {
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

                                    } else if (moom == 4) {
                                        swal("Candidato Actualizado", "Se guardo la información correctamente.", "success")
                                                .then(function () {
                                                    location.href = 'ccateg';
                                                });
                                    }
                                } else if (data == 2) {
                                    swal("No se ingreso ningun nombre de candidato, intente de nuevo.", "", "error");
                                } else if (data == 3) {
                                    swal("No se pudo guardar la imagen en la carpeta, intente de nuevo.", "", "error");
                                } else if (data == 4) {
                                    swal("Error de formato en la imagen debe ser 'image/jpeg' 'image/jpg' 'image/png' 'image/gif', intente de nuevo.", "", "error");
                                } else if (data == 5) {
                                    swal("No se pudo guardar el audio en la carpeta, intente de nuevo.", "", "error");
                                } else if (data == 6) {
                                    swal("Error de formato en el audio debe ser 'audio/mpeg' 'audio/mp3' 'application/octet-stream', intente de nuevo.", "", "error");
                                } else if (data == 7) {
                                    swal("No se guardo la informacion en base de datos, intente de nuevo.", "", "error");
                                }

                            },
                            error: function (data) {
                                swal("Error al guardar la información.", "", "error");
                            }
                        });
                    }
                });
            }
        });
    } else {
        swal("Faltan datos por llenar, intente de nuevo.", "", "warning");
    }


}

function editarCategoria() {
    var error = 0;
    var svcat = $("#editcat").serialize();
    var desCateg = $('#desCateg').val();
    var desCand = $('#desCand').val();
    var generosValues = Array();

    $('input[class=genr]').toArray().some(function (el) {
        if ($(el).val().length > 1) {
            generosValues.push($(el).val());
        }
    });
    if (desCateg == "") {
        error++;
    }
    if (desCand == "") {
        error++;
    }
    if ($("#generoArt").is(':checked')) {
        if (generosValues == '') {
            if ($('#generosnuevos').is(":visible")) {
                swal("Faltan Generos por completar, intente de nuevo.", "", "warning");
                error++;
            } else if ($('#genero').is(":visible")) {
                swal("Faltan Generos por completar, intente de nuevo.", "", "warning");
                error++;
            }
        }
    }

    if (error === 0) {
        swal({
            title: 'Confirmación',
            text: 'Está seguro que quiere actualizar esta categoria?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: 'success',
            cancelButtonColor: 'error',
            cancelButtonText: 'No',
            confirmButtonText: 'Si'
        }).then(function (result) {
            if (result.value) {
                swal({
                    title: 'Actualización de Categoria',
                    html: '<b>Está seguro que quiere actualizar esta categoria?<br></b><font color="red" size="4"> La información anterior sera elimanada y se actualizará con los datos cargados en este formulario.</font><br><br>',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'success',
                    cancelButtonColor: 'red',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Si'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "crearCategoria",
                            type: "post",
                            data: "svcat=" + svcat + '&generosValues=' + generosValues,
                            success: function (data) {
                                if (data === 1) {
                                    swal("Categoria Actualizada", "Se actualizó la categoria correctamente.", "success")
                                            .then(function () {
                                                location.href = 'carea';
                                            });
                                } else {
                                    swal("No se pudo actualizar la categoria, faltan datos por llenar, intente de nuevo.", "", "error");
                                }
                            },
                            error: function (data) {
                                swal("Error al guardar la información.", "", "error");
                            }
                        });
                    }
                });
            }
        });
    } else {
        swal("Faltan datos por llenar, intente de nuevo.", "", "warning");
    }
}
function editarBanner(tipo) {

    var error = 0;
    var _URL = window.URL || window.webkitURL;
    var form_data = new FormData();

    var imgg = $('#imgg').get(0).files[0];
    var posicion_id = $('#posicion_id').val();

    if (tipo == 1) {
        var banner_id = 0;
        var text = 'Está seguro de agregar un nuevo banner?';
        if (imgg == undefined || posicion_id == 0) {
            $("#imgg").focus();
            $("#vimg").addClass("yellow lighten-4");
            $("#pos").addClass("yellow lighten-4");
            error++;
        } else if (imgg != undefined) {
            var file = $('#imgg')[0].files[0];
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
            $("#vimg").removeClass("yellow lighten-4");
        }
    } else if (tipo == 2) {
        banner_id = $('#banner_id').val();
        text = 'Está seguro que quiere actualizar este banner?';
        if (imgg == undefined && posicion_id == 0) {
            $("#imgg").focus();
            $("#vimg").addClass("yellow lighten-4");
            $("#pos").addClass("yellow lighten-4");
            error++;
        } else if (imgg != undefined) {
            var file = $('#imgg')[0].files[0];
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
            $("#vimg").removeClass("yellow lighten-4");
        }
    }

    form_data.append("imgg", imgg);
    form_data.append("posicion_id", posicion_id);
    form_data.append("banner_id", banner_id);
    form_data.append("tipo", tipo);

    if (error === 0) {
        swal({
            title: 'Confirmación',
            text: text,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: 'success',
            cancelButtonColor: 'error',
            cancelButtonText: 'No',
            confirmButtonText: 'Si'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    "url": "crearBanner",
                    "data": form_data,
                    "dataType": 'json',
                    "cache": false,
                    "contentType": false,
                    "processData": false,
                    "type": "post",
                    success: function (data) {
                        if (data === 1) {
                            swal("Administración de Banner", "Se guardo correctamente la imagen.", "success")
                                    .then(function () {
                                        location.href = 'carrusel';
                                    });
                        } else if (data == 2) {
                            swal("No se selecciono ninguna imagen, intente de nuevo.", "", "error");
                        } else if (data == 3) {
                            swal("No se pudo guardar la imagen en la carpeta, intente de nuevo.", "", "error");
                        } else if (data == 4) {
                            swal("Error de formato en la imagen debe ser 'image/jpeg' 'image/jpg' 'image/png' 'image/gif', intente de nuevo.", "", "error");
                        } else if (data == 7) {
                            swal("No se guardo la informacion en base de datos, intente de nuevo.", "", "error");
                        }

                    },
                    error: function (data) {
                        swal("Error al guardar la información.", "", "error");
                    }
                });
            }
        });
    } else {
        swal("Debe seleccionar una imagen o una posición", "", "warning");
    }
}

function updatePos(banner_id, tipo) {

    var posicion_id = $("#posicion_id" + banner_id).val();
    if (tipo == 3) {
        var text = 'Está seguro que desea cambiar la posición esta categoria?';
    } else {
        text = 'Está seguro que desea cambiar la posición este banner?';
    }

    if (posicion_id >= 1 && banner_id >= 1) {
        swal({
            title: 'Confirmación',
            text: text,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: 'success',
            cancelButtonColor: 'danger',
            confirmButtonText: 'Si'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    "url": "crearBanner",
                    "data": {posicion_id: posicion_id, banner_id: banner_id, tipo: tipo, imgg: 'undefined'},
                    "type": "post",
                    "error": function () {
                        swal("Error inesperado", "", "warning");
                    },
                    "success": function (resp) {
                        if (resp == 1) {
                            swal('Cambio exitoso!', "", "success")
                                    .then(function () {
                                        location.reload();
                                    });
                        } else if (resp == 2) {
                            swal("Ha ocurrido un problema, intente de nuevo", "", "error");
                        }
                    }
                });
            }
        });
    }
}

function cambiocolor(posicion_id) {

    if(posicion_id == undefined){
	swal("Debe asignar una posición a la categoria para poder cambiar el color.", "", "warning");
    }else{

    var theInput = document.getElementById("color" + posicion_id);
    var theColor = theInput.value;

    $("#pruebacolor" + posicion_id).css('background', theColor);
    $("#pruebacolor" + posicion_id).html(theColor);

    var form_data = new FormData();

    form_data.append("color", theColor);
    form_data.append("posicion_id", posicion_id);

    if (theColor !== null) {
        swal({
            title: 'Confirmación',
            text: 'Esta seguro de que quiere cambiar el color de la Categoria?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: 'success',
            cancelButtonColor: 'error',
            cancelButtonText: 'No',
            confirmButtonText: 'Si'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    "url": "cambiarColor",
                    "data": form_data,
                    "dataType": 'json',
                    "cache": false,
                    "contentType": false,
                    "processData": false,
                    "type": "post",
                    success: function (data) {
                        if (data === 1) {
                            swal("Administración de Posición", "Se guardo correctamente.", "success")
                                    .then(function () {
                                        location.reload();
                                    });
                        } else if (data == 2) {
                            swal("No se guardo la información, intente de nuevo.", "", "error");
                        }

                    },
                    error: function (data) {
                        swal("Error al guardar la información.", "", "error");
                    }
                });
            }
        });

    }
}
}
