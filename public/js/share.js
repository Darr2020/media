$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });




});

function share() {
    $.ajax({
        url: "/share",
        type: "post",
        data: "",
        success: function (re) {
            $("#ModalG").modal();
            $("#ModalG").modal('open');
            $("#cuerpo").html(re);
        }

    });
}

function feel(encuesta_id, categoria_id, candidato_multimedia_id, candidato_id, tipo_multimedia, emotion,opt) {
    var encuesta_id = encuesta_id;
    var categoria_id = categoria_id;
    var candidato_multimedia_id = candidato_multimedia_id;
    var candidato_id = candidato_id;
    var tipo_multimedia = tipo_multimedia;
    var emotion = emotion;
    var opt = opt;

    $.ajax({
        url: "/feelmm",
        type: "post",
        data: {encuesta_id: encuesta_id, categoria_id: categoria_id, candidato_multimedia_id: candidato_multimedia_id, candidato_id: candidato_id, tipo_multimedia: tipo_multimedia, emotion: emotion},
        dataType: 'json',
        success: function (res) {
            if(opt == 1){
                videos(res.candidato_id, 1, res.encuesta_id, res.emotion, res.me_gusta, res.no_me_gusta, 1);
            }else if(opt == 3){
                videos(res.candidato_id, 3, res.encuesta_id, res.emotion, res.me_gusta, res.no_me_gusta, 1);
            }else if(opt == 2){
                videos(res.candidato_id, 2, res.encuesta_id, res.emotion, res.me_gusta, res.no_me_gusta, 1);
            }else if(opt == 4){
                videos(res.candidato_id, 4, res.encuesta_id, res.emotion, res.me_gusta, res.no_me_gusta, 1);
            }
        }

    });
}