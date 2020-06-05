$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
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

    $('#muestra').validCampo('0123456789.');
    $('#muestra_feme').validCampo('0123456789.');
    $('#muestra_masc').validCampo('0123456789.');
    //fin funcion para bloquear campos solo letras o solo numeros



    $(".input-field").on('keyup change', function () {
        var inp = $(".validate");
        var inp_cal = $(".datepicker");
        var text_area = $(".materialize-textarea");
        var file = $(".btn-file");

        if (
                $(inp[0]).val() == "" ||
                $(inp[1]).val() == "" ||
                $(inp[2]).val() == "" ||
                $(inp_cal[0]).val() == "" ||
                $(inp_cal[1]).val() == "" ||
                $(text_area[0]).val() == "" ||
                file[0].value == ""
                ) {
            if (!$("#button[type='submit']").prop("disabled") == true) {
                $("#button[type='submit']").prop("disabled") == true;
            }
        } else {
            if ($("button[type='submit']").prop("disabled") == true) {
                $("button[type='submit']").prop("disabled", false);
            }
        }

    });


    var inicio = $('#fecha_desde').pickadate(),
            inicio_picker = inicio.pickadate('picker')

    var final = $('#fecha_hasta').pickadate(),
            final_picker = final.pickadate('picker')

// Check if there’s a “from” or “to” date to start with.
    if (inicio_picker.get('value')) {
        final_picker.set('min', inicio_picker.get('select'))
    }
    if (final_picker.get('value')) {
        inicio_picker.set('max', final_picker.get('select'))
    }

// When something is selected, update the “from” and “to” limits.
    inicio_picker.on('set', function (event) {
        if (event.select) {
            final_picker.set('min', inicio_picker.get('select'))
        } else if ('clear' in event) {
            final_picker.set('min', false)
        }
    })
    final_picker.on('set', function (event) {
        if (event.select) {
            inicio_picker.set('max', final_picker.get('select'))
        } else if ('clear' in event) {
            inicio_picker.set('max', false)
        }
    })



    $(".enc1").click(function (e) {
        e.preventDefault();

        var fecha_desde = $("#fecha_desde").val();
        var fecha_hasta = $("#fecha_hasta").val();
        var muestra = parseInt($("#muestra").val());
        var muestra_feme = $("#muestra_feme").val();
        var muestra_masc = $("#muestra_masc").val();
        var descripcion = $("#descripcion").val();
        var suma_muestra = parseInt(muestra_feme) + parseInt(muestra_masc)
        var e = 0;

/////////////////////////////////////////////


/////////////////////////////////////////////
        if (fecha_desde == "") {
            swal('¡Aviso!', "Ingrese la fecha desde", "warning");
            e++;
        }
        if (fecha_hasta == "") {
            swal('¡Aviso!', "Ingrese la fecha hasta", "warning");
            e++;
        }
        if (muestra == "") {
            swal('¡Aviso!', "Ingrese la muestra", "warning");
            e++;
        }
        if (muestra_feme == "") {
            swal('¡Aviso!', "Ingrese la muestra femenina", "warning");
        }
        if (muestra_masc == "") {
            swal('¡Aviso!', "Ingrese la muestra femenina", "warning");
            e++;
        }
        if (descripcion == "") {
            swal('¡Aviso!', "Ingrese la descripcion", "warning");
            e++;
        }

        if(suma_muestra === muestra){
            var form_data = new FormData();
            form_data.append("file", $('#archivo').get(0).files[0]);
            form_data.append("fecha_desde", fecha_desde);
            form_data.append("fecha_hasta", fecha_hasta);
            form_data.append("muestra", muestra);
            form_data.append("muestra_feme", muestra_feme);
            form_data.append("muestra_masc", muestra_masc);
            form_data.append("descripcion", descripcion);

            if (e === 0) {
                $.ajax({
                    "url": "/save_poll",
                    "data": form_data,
                    "dataType": 'json',
                    "cache": false,
                    "contentType": false,
                    "processData": false,
                    "type": "post",
                    "success": function (data) {
                        if (data == 1) {
                            swal("Registro exitoso.", "", "success");
                            setTimeout(function () {
                                location.href = "/backend/enc_index";
                            }, 1500);
                        } else if (data == 3) {
                            swal('¡Error!', "Error 3", "error");
                        } else if (data == 4) {
                            swal('¡Error!', "Error 4", "error");
                        } else if (data == 5) {
                            swal('¡Aviso!', "El archivo no cumple cumple con el formato pdf", "warning");
                        } else if (data == 2) {
                            swal('¡Error!', "Error 2", "error");
                        } else if (data == 0) {
                            swal('¡Error!', "Error 0", "error");
                        }
                    },
                    "error": function () {
                        swal('¡Error!', "Error de servidor", "error");
                    }
                });
            } else {
                swal("¡Aviso!.", "Complete el dato solicitado", "warning");
            }
        }else{
          swal('¡Aviso!', "La suma de las muestra femenina y masculina "+ suma_muestra+" debe ser igual a la muestra "+muestra, "warning");  
        }

    });

}); /////////////

        