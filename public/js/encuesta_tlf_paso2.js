$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });

    $("#dataTable").dataTable().fnDestroy();
    $('#dataTable').DataTable({
        lengthMenu: [[20, 40, 60, 100, 500, -1], [20, 40, 60, 100, 500, "Todos"]],
        dom: 'Blfrtip',
        buttons: [
//                    'csv', 'excel', 'pdf'
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

});

/////////////////////////////// FUNCIONES ///////////////////////////////

//Solo para cuando la EW es en blanco (i)
function addOrdenPuntaje(valor,cand_id,enc_id,flag,cat_id) {
    var valor = valor;
    var enc_id = enc_id;
    var cat_id = cat_id;
    var cand_id = cand_id;
    var flag = flag;
    var form = $('#form_opinicial');
    var ruta = form.attr('action');

    $.ajax({
        url: "/saveiOrdPto",
        data: {enc_id: enc_id, cand_id: cand_id, valor: valor, flag: flag,cat_id:cat_id},
        type: "post",
        success: function (res) {
            if (res == 1) {
                swal("Proceso exitoso.", "", "success");
                setTimeout(function () {
                    location.href = ruta;
                }, 1000);
            } else if (res == 2) {
                swal('¡Error!', "Error 2", "error");
            }
        }
    });
}

function actualizar_puntaje() {
    var enc_id = $("#enc_id").val();
    var cat_id = $("#cat_id").val(); //categoria id
    var form_data = new FormData();
    var objeto_candidatos = []
    var form = $('#form_puntaje_edit');
    var ruta = form.attr('action');

    $("input[name^='puntaje']").each(function () {
        var candidato = $(this).data('id');
        if (this.value != "") {
            objeto_candidatos.push({candidato: candidato, valor: $(this).val()});
        }
    });

    $.each(objeto_candidatos, function (index, elemento) {
        form_data.append("candidato_puntaje[" + elemento['candidato'] + "]", elemento['valor']);

    });

    form_data.append("enc_id", enc_id);
    form_data.append("id", cat_id);

    $.ajax({
        "url": "/verifyData",
        "data": form_data,
        "cache": false,
        "contentType": false,
        "processData": false,
        "type": "post",
        "success": function (res) {
            if (res == '') {
                swal("Proceso exitoso.", "", "success");
                setTimeout(function () {
                    location.href = ruta;
                }, 1500);
            } else if (res == 'fallo') {
                swal('¡Error!', "Ha ocurrido un error durante el proceso", "error");
            } else if (res == 0) {
                swal('¡Aviso!', "Debe ingresar al menos un puntaje en los candidatos", "warning");
            }

        },
        "error": function () {
            swal("Error de servidor");
        }
    });
}



function publicar_encTlf(enc_id) {
    swal({
        title: '¿Estas seguro?',
        text: "Una vez que se publique la encuesta, no podrá editarse.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/ppoll_push",
                type: "post",
                data: {enc_id: enc_id},
                success: function (resp) {
                    if (resp == 1) {
                        swal("Éxito", "Proceso realizado exitosamente.", "success");
                        setTimeout(function () {
                            location.href = "/backend/enc_index";
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    }
                }
            });
        }
    });

}


function crear_enc_web_de_tlf() {
    swal({
        title: '¿Estas seguro?',
        text: "Esta seguro de que quiere generar la encuesta web a partir de una telefónica",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/enc_web_tlf",
                type: "post",
                data: "",
                success: function (resp) {
                    if (resp == 1) {
                        swal("Éxito", "Se creó la encuesta web.", "success");
                        setTimeout(function () {
                            location.href = "encweb_index";
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    } else if (resp == 3) {
                        swal('¡Error!', "Error 3", "error");
                    }
                }
            });
        }
    });
}


function actualizar_puntaje_web() {
    var enc_id = $("#enc_id").val();
    var cat_id = $("#cat_id").val(); //categoria id
    var form_data = new FormData();
    var objeto_candidatos = []
    var form = $('#form_puntajeweb');
    var ruta = form.attr('action');

    $("input[name^='puntajeweb']").each(function () {
        var candidato = $(this).data('id');
        if (this.value != "") {
            objeto_candidatos.push({candidato: candidato, valor: $(this).val()});
        }
    });

    $.each(objeto_candidatos, function (index, elemento) {
        form_data.append("candidato_puntajeweb[" + elemento['candidato'] + "]", elemento['valor']);
    });

    form_data.append("enc_id", enc_id);
    form_data.append("id", cat_id);

    $.ajax({
        "url": "/verifyDataEncWeb",
        "data": form_data,
        "cache": false,
        "contentType": false,
        "processData": false,
        "type": "post",
        "success": function (res) {
            if (res == '') {
                swal("Proceso exitoso.", "", "success");
                setTimeout(function () {
                    location.href = ruta;
                }, 1500);
            } else if (res == 'fallo') {
                swal('¡Error!', "Ha ocurrido un error durante el proceso", "error");
            } else if (res == 0) {
                swal('¡Aviso!', "Debe ingresar al menos un puntaje en los candidatos", "warning");
            }

        },
        "error": function () {
            swal("Error de servidor");
        }
    });
}


function actualizar_orden_web() {
    var enc_id = $("#enc_id").val();
    var cat_id = $("#cat_id").val(); //categoria id
    var form_data = new FormData();
    var objeto_candidatos = []
    var form = $('#form_ordenweb');
    var ruta = form.attr('action');

    $("input[name^='ordenweb']").each(function () {
        var candidato = $(this).data('id');
        if (this.value != "") {
            objeto_candidatos.push({candidato: candidato, valor: $(this).val()});
        }
    });

    $.each(objeto_candidatos, function (index, elemento) {
        form_data.append("candidato_ordenweb[" + elemento['candidato'] + "]", elemento['valor']);
    });

    form_data.append("enc_id", enc_id);
    form_data.append("id", cat_id);

    $.ajax({
        "url": "/verifyDataEOWeb",
        "data": form_data,
        "cache": false,
        "contentType": false,
        "processData": false,
        "type": "post",
        "success": function (res) {
            if (res == '') {
                swal("Proceso exitoso.", "", "success");
                setTimeout(function () {
                    location.href = ruta;
                }, 1500);
            } else if (res == 'fallo') {
                swal('¡Error!', "Ha ocurrido un error durante el proceso", "error");
            } else if (res == 0) {
                swal('¡Aviso!', "Debe ingresar al menos un orden a los candidatos", "warning");
            }
        },
        "error": function () {
            swal("Error de servidor");
        }
    });
}



function publicar_encWeb(enc_id) {
    swal({
        title: '¿Estas seguro?',
        text: "Una vez que se publique la encuesta, no podrá editarse.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/wpoll_push",
                type: "post",
                data: {enc_id: enc_id},
                success: function (resp) {
                    if (resp == 1) {
                        swal("Éxito", "Proceso realizado exitosamente.", "success");
                        setTimeout(function () {
                            location.href = "encweb_index";
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    }
                     else if (resp == 3) {
                        swal('¡Error!', "Error 3", "error");
                    }
                }
            });
        }
    });
}


function crear_enc_web_vacia() {
    swal({
        title: '¿Estas seguro?',
        text: "Esta seguro de que quiere generar la encuesta web",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/enc_web_vacia",
                type: "post",
                data: "",
                success: function (res) {
                    if (res == 1) {
                        swal("Éxito", "Se creó la encuesta web.", "success");
                        setTimeout(function () {
                            location.href = "encweb_index";
                        }, 1500);
                    } else if (res == 2) {
                        swal('¡Error!', "Error 2", "error");
                    } else if (res == 3) {
                        swal('¡Error!', "Error 3", "error");
                    }
                }
            });
        }
    });
}


function remover_opcion(cand_id, enc_id,cat_id) {
    var form = $('#form_remover');
    var ruta = form.attr('action');
    swal({
        title: '¿Estas seguro?',
        text: " De qué quiere remover la opción",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/remover_ec",
                type: "post",
                data: {cand_id: cand_id, enc_id: enc_id,cat_id:cat_id},
                success: function (resp) {
                    if (resp == 1) {
                        swal("Éxito", "Proceso realizado exitosamente.", "success");
                        setTimeout(function () {
                            location.href = ruta;
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    }
                }

            }); ///AJAX
        }
    });
}


///////Crear una EW a partir de la última EW publicada
function crear_enc_web_ult() {
    swal({
        title: '¿Estas seguro?',
        text: "Esta seguro de que quiere generar la encuesta a partir de la última encuesta web",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/enc_web_ult",
                type: "post",
                data: "",
                success: function (resp) {
                    if (resp == 1) {
                        swal("Éxito", "Se creó la encuesta web.", "success");
                        setTimeout(function () {
                            location.href = "encweb_index";
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    } else if (resp == 3) {
                        swal('¡Error!', "Error 3", "error");
                    }
                }
            });
        }
    });
}


function remover_cat_etlf(enc_id,cat_id,valor) {
    swal({
        title: '¿Estas seguro?',
        text: " De qué quiere remover la categoría de la encuesta",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/remover_cat_etlf",
                type: "post",
                data: {enc_id: enc_id,cat_id:cat_id,valor:valor},
                success: function (resp) {

                    if (resp == 1) {
                        swal("Éxito", "Proceso realizado exitosamente.", "success");
                        setTimeout(function () {
                            location.href = "/backend/enc_tlfP2/"+enc_id;
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    }
                    
                }

            }); ///AJAX
        }
    });
}

function remover_cat_eweb(enc_id,cat_id,valor) {
    //alert(enc_id+' - '+cat_id+' - '+valor);
    swal({
        title: '¿Estas seguro?',
        text: " De qué quiere remover la categoría de la encuesta",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/remover_cat_eweb",
                type: "post",
                data: {enc_id: enc_id,cat_id:cat_id,valor:valor},
                success: function (resp) {

                    if (resp == 1) {
                        swal("Éxito", "Proceso realizado exitosamente.", "success");
                        setTimeout(function () {
                            location.href = "/backend/encwebP2/"+enc_id;
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    }
                    
                }

            }); ///AJAX
        }
    });
}


///////Crear una EW a partir de la última EW publicada
function crear_enc_tlf_ult() {
    swal({
        title: '¿Estas seguro?',
        text: "Esta seguro de que quiere generar la encuesta a partir de la última encuesta telefónica",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: 'success',
        cancelButtonColor: 'danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "/enc_tlf_ult",
                type: "post",
                data: "",
                success: function (resp) {
                    if (resp == 1) {
                        swal("Éxito", "Se creó la encuesta telefónica.", "success");
                        setTimeout(function () {
                            location.href = "/backend/enc_index";
                        }, 1500);
                    } else if (resp == 2) {
                        swal('¡Error!', "Error 2", "error");
                    } else if (resp == 3) {
                        swal('¡Error!', "Error 3", "error");
                    }
                }
            });
        }
    });
}
