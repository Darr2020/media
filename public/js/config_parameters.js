$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
});

function guardar_cparams(){
    var form_data = new FormData();
    var obj_params = []
    var flag = $("#flag").val();
    var param_value = $("#param_value").val();
    var e=0

    if(flag == 1){
        if(param_value == ""){
            $("#param_value").addClass("yellow lighten-4");
            swal('¡Aviso!', "Ingrese el valor del parametro", "warning");
            e++;
        } 
        if (e === 0) {
            form_data.append("cf_param_id", $("#cf_param_id").val());
            form_data.append("param_value", param_value);
            form_data.append("flag", flag);

            $.ajax({
                "url": "/update_confpa",
                "data": form_data,
                "cache": false,
                "contentType": false,
                "processData": false,
                "type": "post",
                "success": function (res) {
                    if (res == 1) {
                        swal("Proceso exitoso.", "", "success");
                        setTimeout(function () {
                            location.href = "/backend/index_cfparams";
                        }, 1500);
                    } else if (res == 2) {
                        swal('¡Error!', "Error 2", "error");
                    } 
                },
                "error": function () {
                    swal("Error de servidor");
                }
            });
        }

    }

    if(flag == 0){
        var param_name = $("#param_name").val();

        if(param_name == ""){
            $("#param_name").addClass("yellow lighten-4");
            swal('¡Aviso!', "Ingrese el nombre del parametro", "warning");
            e++;
        }        
        if(param_value == ""){
            $("#param_value").addClass("yellow lighten-4");
            swal('¡Aviso!', "Ingrese el valor del parametro", "warning");
            e++;
        }  

        if (e === 0) {
            form_data.append("param_name", param_name);
            form_data.append("param_value", param_value);
            form_data.append("flag", flag);

            $.ajax({
                "url": "/update_confpa",
                "data": form_data,
                "cache": false,
                "contentType": false,
                "processData": false,
                "type": "post",
                "success": function (res) {
                    if (res == 1) {
                        swal("Proceso exitoso.", "", "success");
                        setTimeout(function () {
                            location.href = "/backend/index_cfparams";
                        }, 1500);
                    } else if (res == 2) {
                        swal('¡Error!', "Error 2", "error");
                    } 
                },
                "error": function () {
                    swal("Error de servidor");
                }
            });
        }
    }
}


function new_cfparam(){
    $.ajax({
        url: "/new_cf_param",
        type: "post",
        data: "",
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpo").html(re);
        }

    });
}

function edit_cfparam(cf_param_id){
    $.ajax({
        url: "/edit_cf_param",
        type: "post",
        data: {cf_param_id:cf_param_id },
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpo").html(re);
        }

    });
}