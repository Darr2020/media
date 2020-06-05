$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(".login_bac").click(function (e) {
        e.preventDefault();
        var usuario = $("#correo").val();
        var clave = $("#clave").val();
        var flagi = $("#flagi").val();

        if (usuario != "" || clave != "")
        {
            $.ajax({
                'method': 'POST',
                'url': '/checkb',
                'data': {usuario: usuario, clave: clave,flagi:flagi},
                'success': function (response) {
                    if (response == 1) {
                        swal({
                            "title": "Ingresando...",
                            "type": "success",
                        });
                        setTimeout(function () {
                            location.href = "/backend/inicio";
                        }, 1500)
                    }
                      else if (response == 0) {
                        swal({
                            "title": "Redirigiendo...",
                            "type": "success",
                        });
                        setTimeout(function () {
                            location.href = "/backend/userb_cp";
                        }, 1000)
                    }
                     else if (response == 90) {
                        swal('¡Error!', 'Estimado usuario,debe registrarse para poder ingresar al sistema, comuniquese con el personal de informática', 'error');
                    }  else if (response == 91) {
                        swal('¡Aviso!', 'La contraseña ingresada es incorrecta', 'warning');
                    } else if (response == 92) {
                        swal('¡Error!', 'Estimado usuario, usted no tiene permisos para ingresar, comuniquese con el personal de informática', 'error');
                    }else if (response == 4) {
                        swal('¡Aviso!', 'Usuario inactivo, comuniquese con el personal de informática', 'warning');
                    }
                },
                'error': function () {
                    swal('¡Error!', 'Ha ocurrido un problema interno', 'error')
                }
            });
        } else {
            swal('¡Aviso!', 'Debe llenar los Campos', 'warning')
        }
    });

});

///////////////// functions ///////////
function loginf() {
    var usuario = $("#correo").val();
    var clave = $("#clave").val();
    var flagi = $("#flagi").val();

    if (usuario != "" || clave != "")
    {
        $.ajax({
            method: 'POST',
            url: '/checkf',
            data: {usuario: usuario, clave: clave,flagi:flagi},
            success: function (response) {
                if (response == 1) {
                    swal({
                        "title": "Ingresando...",
                        "type": "success",
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1500)
                } else if (response == 90 || response == 92) {
                    swal('¡Error!', 'Estimado usuario, debe registrarse para poder ingresar al sistema.', 'error');
                } else if (response == 91) {
                    swal('¡Aviso!', 'La contraseña ingresada es incorrecta', 'warning');
                }else if (response == 4) {
                        swal('¡Aviso!', 'Usuario inactivo', 'warning');
                }
            },
            error: function () {
                swal('¡Error!', 'Ha ocurrido un problema interno', 'error')
            }
        });
    } else {
        swal('¡Aviso!', 'Debe llenar los campos solicitados', 'warning')
    }
}


function registrarf() {
    var nombre = $('#nombrelf').val();
    var correo = $('#correolf').val();
    var password = $('#passwordlf').val();
    var password_again = $('#password_againlf').val();
    var e = 0;

    if (nombre == "") {
        $("#nombrelf").addClass("yellow lighten-4");
        e++;
    } else {
        $("#nombrelf").removeClass("yellow lighten-4");
    }
    if (correo == "") {
        $("#correolf").addClass("yellow lighten-4");
        e++;
    } else {
        $("#correolf").removeClass("yellow lighten-4");
    }
    if (password == "") {
        $("#passwordlf").addClass("yellow lighten-4");
        e++;
    } else {
        $("#passwordlf").removeClass("yellow lighten-4");
    }
    if (password_again == "") {
        $("#password_againlf").addClass("yellow lighten-4");
        e++;
    } else {
        $("#password_againlf").removeClass("yellow lighten-4");
    }

    if (e == 0) {
        if (password_again === password && (nombre != '' && correo != '')) {
            if (valida_correo(correo)) {
                /////AJAX
                $.ajax({
                    method: 'POST',
                    url: '/registrarUF',
                    data: {nombre: nombre, correo: correo, password: password, password_again: password_again},
                    success: function (response) {
                        if (response == 1) {
                            swal("Registro exitoso.", "", "success");
                            setTimeout(function () {
                                location.href = "/";
                            }, 1500)
                        } else if (response == 0) {
                            swal('¡Aviso!', 'Las contraseñas no coinciden', 'warning');
                        } else if (response == 2) {
                            swal('¡Aviso!', 'Error2', 'warning');
                        }
                    },
                    error: function () {
                        swal('¡Error!', 'Ha ocurrido un problema interno', 'error')
                    }
                });
            } else {
                swal('¡Aviso!', 'No es un formato de correo valido', 'warning')
            }

        } else {
            swal('¡Aviso!', 'Las contraseñas no coinciden', 'warning')
        }
    } else {
        swal("¡Aviso!.", "Complete información solicitada", "warning");
    }
}


function ingresarfm() {
    $.ajax({
        url: "/authf",
        type: "post",
        data: "",
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpoModal").html(re);
        }

    });

}

function registrarsefm() {
    $.ajax({
        url: "/registerf",
        type: "post",
        data: "",
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpoModal").html(re);
        }

    });

}

function recuperarclavefm() {
    $.ajax({
        url: "/forgotpf",
        type: "post",
        data: "",
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpoModal").html(re);
        }

    });

}


function valida_correo(valor) {
    regx = /^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{1,9})$/;
    return regx.test(valor);
}
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