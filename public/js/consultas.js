$(document).ready(function () {
    $.ajaxSetup({
        headers: {"X-CSRF-Token": $("meta[name=_token]").attr("content")}
    });

    $('#categ').on("change", function () {
        var nextinput = 0;
        $(".redessocc").remove();
        $(".gennnn").remove();
        $('input:radio[name=gen]').prop('checked', false);
        $(".fomul").val('');
        $("#guardarcand").show();
        $("#opcfr").show();
        $("#forcandop").removeClass("yellow lighten-4");
        $("#nuevo").hide();
        $("#editar").hide();
        $("#agregarRedes").hide();
        $("#eliminarRedes").hide();
        var categ_id = $(this).val();
        if (categ_id >= 1) {
            $.ajax({
                url: "busCatg",
                type: "post",
                data: "id=" + categ_id,
                success: function (data) {
                    if (data.opciones[0].nombre === true) {
                        $("#1").show();
                    } else {
                        $("#1").hide();
                    }
                    if (data.opciones[0].infor === true) {
                        $("#2").show();
                    } else {
                        $("#2").hide();
                    }
                    if (data.opciones[0].gen === true) {
                        $("#3").show();
                    } else {
                        $("#3").hide();
                    }
                    if (data.opciones[0].img === true) {
                        $("#5").show();
                    } else {
                        $("#5").hide();
                    }
                    if (data.opciones[0].audio === true) {
                        $("#6").show();
                    } else {
                        $("#6").hide();
                    }
                    if (data.opciones[0].video === true) {
                        $("#7").show();
                    } else {
                        $("#7").hide();
                    }
                    if (data.opciones[0].pag === true) {
                        $("#9").show();
                    } else {
                        $("#9").hide();
                    }
                    if (data.opciones[0].cia === true) {
                        $("#10").show();
                    } else {
                        $("#10").hide();
                    }
                    if (data.opciones[0].seg === true) {
                        $("#11").show();
                    } else {
                        $("#11").hide();
                    }
                    if (data.opciones[0].generoart === true) {
                        $("#4").show();
                        $(".gennnn").parent('div').remove();
                        var contadorgen = 0;
                        $.each(data.generos, function (i, c) {
                            $("#generoArtt").append('<div class="col s8 m8 l8 gennnn">' + c.nomgenero + '</div><div class="col s4 m4 l4 gennnn"><input class="gennnn" type="checkbox" id="generoArtt[' + contadorgen + ']" name="generoArtt" value="' + c.id + '"/><label for="generoArtt[' + contadorgen + ']"></label></div>');
                            contadorgen++;
                        });
                    } else {
                        $("#4").hide();
                    }

                    if (data.opciones[0].redes === true) {
                        $("#8").show();
                        camposgen = '<input type="text" class="redessocc" id="redess[' + nextinput + ']" name="redess"/>';
                        $("#camposgenn").append(camposgen);
                        $("#agregarRedes").show();
                        $("#eliminarRedes").show();
                    } else {
                        $("#8").hide();
                        $("#agregarRedes").hide();
                        $("#eliminarRedes").hide();
                    }

                    /**/
                }
            });
        } else {
            $(".redessocc").remove();
            $('input:radio[name=gen]').prop('checked', false);
            $(".fomul").val('');
            $("#guardarcand").hide();
            $("#opcfr").hide();
        }
    });

    $('#buscarcand').click(function () {
        $("#nuevo").hide();
        $("#editar").hide();
        $(".editab").remove();
        var categ = $("#categ").val();
        var nombre = $("#nombree").val();
        $.ajax({
            data: {id: categ, nombre: nombre},
            url: "buscandoCandidato",
            type: 'POST',
            dataType: 'json',
            success: function (r) {
                if (r == false) {
                    $("#nuevo").show();
                    $("#editar").hide();
                } else {
                    $("#editar").show();
                    $("#nuevo").hide();
                    $.each(r, function (i, c) {
                        $.each(c, function (i, d) {
                            $("#editables").append('<div class="col s5 m5 l5 editab">Editar a: ' + d.nombrecandidato + '</div><div class="col s7 m7 l7 left editab"><a onclick="consultar(' + d.id + ',' + 8 + ')" class="btn cyan waves-effect waves-light editab" style="font-size: 12.6px;">Editar <i class="material-icons right">edit</i></a><br><br></div>');
                        });
                    });
                }
            }
        });
    });

    $("#consulta_categorias").dataTable().fnDestroy();
    $("#consulta_categorias").DataTable({
        "language": lang,
        "ajax": {
            url: "carea/",
            type: "get",
            dataSrc: ""
        },
        "columns": [
            {
                "data": "nombre",
                "className": "justify",
            },
            {
                "data": null,
                "className": "justify",
                "render": function (o) {
                    return o.descateg.substr(0, 10) + ' ...';
                }
            },
            {
                "data": null,
                "className": "justify",
                "render": function (o) {
                    return o.descand.substr(0, 10) + ' ...';
                }
            },
            {
                "data": null,
                "className": "center",
                "render": function (o) {
                    if (o.estatus === 1) {
                        return '<a onclick="confirmar(' + o.id + ',' + 1 + ', ' + 2 + ')" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">Inactivar <i class="material-icons right">visibility_off</i></a>';
                    } else {
                        return '<a onclick="confirmar(' + o.id + ',' + 2 + ', ' + 1 + ')" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Activar <i class="material-icons right">visibility</i></a>';
                    }
                }
            },
            {
                "data": null,
                "className": "center",
                "render": function (o) {
                    return '<a onclick="consultar(' + o.id + ',' + 3 + ',' + o.contcand + ')" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Ver <i class="material-icons right">search</i></a>';
                }
            },
            {
                "data": null,
                "className": "center",
                "render": function (o) {
                    if (o.contcand === 0 && o.estatus === 1) {
                        return '<a onclick="consultar(' + o.id + ',' + 4 + ',' + o.contcand + ')" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Editar <i class="material-icons right">edit</i></a>';
                    } else {
                        return '<a class="btn cyan waves-effect waves-light" style="font-size: 12.6px;" disabled>Editar <i class="material-icons right">edit</i></a>';
                    }
                }
            }
        ]
    });

    $('#categ').on("change", function () {
        var id = $(this).val();
        if (id >= 1) {
            $("#consulta_candidato").dataTable().fnDestroy();
            $("#consulta_candidato").DataTable({
                "language": lang,
                "ajax": {
                    url: "busCand",
                    type: "post",
                    data: {
                        "id": id
                    },
                    dataSrc: ""
                },
                "columns": [
                    {
                        "data": "nombre",
                        "className": "center",
                    },
                    {
                        "data": null,
                        "className": "justify",
                        "render": function (o) {
                            if (o.detalle !== null) {
                                return o.detalle.substr(0, 20) + ' ...';
                            } else {
                                return '';
                            }

                        }
                    },
                    {
                        "data": null,
                        "className": "center",
                        "render": function (o) {
                            if (o.estatus === 1) {
                                return '<a onclick="confirmar(' + o.id + ',' + 5 + ', ' + 2 + ')" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">Inactivar <i class="material-icons right">visibility_off</i></a>';
                            } else {
                                return '<a onclick="confirmar(' + o.id + ',' + 6 + ', ' + 1 + ')" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Activar <i class="material-icons right">visibility</i></a>';
                            }
                        }
                    },
                    {
                        "data": null,
                        "className": "center",
                        "render": function (o) {
                            return '<a onclick="consultar(' + o.id + ',' + 7 + ')" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Ver <i class="material-icons right">search</i></a>';
                        }
                    },
                    {
                        "data": null,
                        "className": "center",
                        "render": function (o) {
                            if (o.estatus === 1) {
                                return '<a onclick="consultar(' + o.id + ',' + 8 + ')" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Editar <i class="material-icons right">edit</i></a>';
                            } else {
                                return '<a class="btn cyan waves-effect waves-light" style="font-size: 12.6px;" disabled>Editar <i class="material-icons right">edit</i></a>';
                            }
                        }
                    }

                ]

            });
            $('#consulta_candidato').show();
        } else {
            $('#consulta_candidato').hide();
        }
    });
    $("#poscateg").dataTable().fnDestroy();
    $("#poscateg").DataTable({
        "language": lang,
    });
    /**Fin Consultas**/

});


function consultar(id, opt, cond) {

    var error = 0;

    if (opt == 4 && cond != 0) {
        swal("Esta Categoria no se puede editar!", "", "warning");
        error++;
    }

    if (error == 0) {
        $.ajax({
            url: "/consultas",
            type: "post",
            data: {id: id, opt: opt, cond: cond},
            success: function (res) {
                $("#myModal").modal();
                $("#myModal").modal('open');
                $("#myModal").addClass("tammodal");
                $("#cuerpo").html(res);
            }

        });
    }

}

function masImg(id, opt, cond) {

    if (opt == 1 || opt == 4) {

        $.ajax({
            url: "/admbanner",
            type: "post",
            data: {id: id, opt: opt},
            success: function (res) {
                $("#myModal").modal();
                $("#myModal").modal('open');
                $("#myModal").addClass("tammodal");
                $("#cuerpo").html(res);
                $("select").material_select();
            }
        });
    }

    if (opt == 2 || opt == 3) {
        var texto;
        var mensaje;
        if (opt === 2) {
            texto = "Está seguro que desea inactivar este banner?";
            mensaje = "Inactivación exitosa.";
        } else if (opt === 3) {
            texto = "Está seguro que desea activar este banner?";
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
                    "url": "/activacbanner",
                    "data": {id: id, opt: opt, estatus: cond},
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

}
