$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(".change_pass").click(function (e) {
        e.preventDefault();
        var user_id = $("#user_id").val();
        var clave = $("#clave").val();
        var clave_re = $("#clave_re").val();
        e=0;

        if (clave == "") {
            $("#clave").addClass("yellow lighten-4");
            swal('¡Aviso!', "Ingrese la contraseña", "warning");
            e++;
        } else {
            $("#clave").removeClass("yellow lighten-4");
        }
        if (clave_re == "") {
            $("#clave_re").addClass("yellow lighten-4");
            swal('¡Aviso!', "Repita la contraseña", "warning");
            e++;
        } else {
            $("#clave_re").removeClass("yellow lighten-4");
        }

        if (e == 0) {
            $.ajax({
                'method': 'POST',
                'url': '/changePassUB',
                'data': {user_id: user_id, clave: clave,clave_re:clave_re},
                'success': function (response) {
                    
                    if (response == 1) {
                        swal({
                            "title": "Redirigiendo...",
                            "type": "success",
                        });
                        setTimeout(function () {
                            location.href = "/backend";
                        }, 1500)
                    } else if (response == 0) {
                        swal('¡Aviso!', 'Las claves no coinciden', 'warning');
                    }  else if (response == 2) {
                        swal(' ¡Error!', 'Error2', 'error' );
                    } 
                    
                },
                'error': function () {
                    swal('¡Error!', 'Ha ocurrido un problema interno', 'error')
                }
            });



        }



    });

});

function new_userb() {
    $.ajax({
        url: "/new_userb",
        type: "post",
        data: "",
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpo").html(re);
        }
    });
}


function save_userb() {
    var nombreb = $('#nombreb').val();
    var correob = $('#correob').val();
    var perfilb = $('#perfilb').val();
    var e = 0;

    if (nombreb == "") {
        $("#nombreb").addClass("yellow lighten-4");
        e++;
    } else {
        $("#nombreb").removeClass("yellow lighten-4");
    }
    if (correob == "") {
        $("#correob").addClass("yellow lighten-4");
        e++;
    } else {
        $("#correob").removeClass("yellow lighten-4");
    }

    if (perfilb == "") {
        $("#perfilb").addClass("yellow lighten-4");
        e++;
    } else {
        $("#perfilb").removeClass("yellow lighten-4");
    }

     if (e == 0) {
        if (valida_correo(correob)) {
                /////AJAX
                $.ajax({
                    method: 'Post',
                    url: '/saveUserb',
                    data: {nombreb: nombreb, correob: correob, perfilb:perfilb},
                    success: function (response) {
                      
                        if (response == 1) {
                            swal("Registro exitoso.", "", "success");
                            setTimeout(function () {
                                location.href = "admin_users";
                            }, 1500)
                        } else if (response == 2) {
                            swal('¡Aviso!', 'Error2', 'warning');
                        }else if (response == 0) {
                            swal('¡Aviso!', 'Estimado usuario el correo ingresado ya se encuestra registrado en el sistema', 'warning');
                        }
                        
                    },
                    error: function () {
                        swal('¡Error!', 'Ha ocurrido un problema interno', 'error')
                    }
                });
        }else {
            swal('¡Aviso!', 'No es un formato de correo valido', 'warning')
        }
     }
}

function status_userb(user_id,valor){
    var user_id = user_id;
    var valor = valor;
    $.ajax({
        url: "/changeStatusUB",
        type: "post",
        data: {user_id: user_id, valor: valor},
        success: function (resp) {
            if (resp == 1) {
                swal("Éxito", "Proceso realizado exitosamente.", "success");
                setTimeout(function () {
                    location.href = "/backend/admin_users";
                }, 1500);
            } else if (resp == 2) {
                swal('¡Error!', "Error 2", "error");
            }
        }
    }); ///AJAX
}

function reboot_pass_userb(user_id){
    var user_id = user_id;
    $.ajax({
        url: "/rebootPUB",
        type: "post",
        data: {user_id:user_id},
        success: function (resp) {
            if (resp == 1) {
                swal("Éxito", "Proceso realizado exitosamente.", "success");
                setTimeout(function () {
                    location.href = "/backend/admin_users";
                }, 1500);
            } else if (resp == 2) {
                swal('¡Error!', "Error 2", "error");
            }
        }
    }); ///AJAX
}

function edit_userb(user_id){
    var user_id = user_id;
    $.ajax({
        url: "/update_userb",
        type: "post",
        data: {user_id:user_id},
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpo").html(re);
        }
    });
}



function save_editUserb(){
var nombreb = $('#nombreb').val();
var correob = $('#correob').val();
var user_id = $('#user_id').val();
var perfilb = $('#perfilb').val();
var e = 0;

    if (nombreb == "") {
        $("#nombreb").addClass("yellow lighten-4");
        e++;
    } else {
        $("#nombreb").removeClass("yellow lighten-4");
    }
    if (correob == "") {
        $("#correob").addClass("yellow lighten-4");
        e++;
    } else {
        $("#correob").removeClass("yellow lighten-4");
    }

    if (perfilb == "") {
        $("#perfilb").addClass("yellow lighten-4");
        e++;
    } else {
        $("#perfilb").removeClass("yellow lighten-4");
    }

     if (e == 0) {
        if (valida_correo(correob)) {
                /////AJAX
                $.ajax({
                    method: 'Post',
                    url: '/modificarUserb',
                    data: {user_id:user_id,nombreb: nombreb, correob: correob, perfilb:perfilb},
                    success: function (response) {
                        if (response == 1) {
                            swal("Proceso exitoso.", "", "success");
                            setTimeout(function () {
                                location.href = "admin_users";
                            }, 1500)
                        } else if (response == 2) {
                            swal('¡Aviso!', 'Error2', 'warning');
                        }else if (response == 0) {
                            swal('¡Aviso!', 'Estimado usuario el correo ingresado ya se encuestra registrado en el sistema', 'warning');
                        }
                        
                    },
                    error: function () {
                        swal('¡Error!', 'Ha ocurrido un problema interno', 'error')
                    }
                });
        }else {
            swal('¡Aviso!', 'No es un formato de correo valido', 'warning')
        }
     }

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