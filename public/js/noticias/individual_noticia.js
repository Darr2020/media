var app = angular.module('myApp', []);

var noticia_id = $("span#newcode").text();

app.controller('comentsController', ($scope, $http) => {
    $scope.buttons = {};
    $scope.comentarios = [];
    $scope.approved = [];
    $scope.buttons.mas = false;

    $scope.formatDate = date => {
        return new Date(date)
    }

    $scope.displayMore = () => {
        var news = $scope.approved.splice(0,5);
        news.forEach((item, key) => {
            $scope.comentarios.push(item)    
        })
    }

    $scope.displayComments = (quantity = null) => {
        $scope.comentarios = $scope.approved.splice(0, (!quantity) ? 5:quantity);
    }

    $http.get('/api/comments/'+noticia_id).then(res => {
        $scope.approved = res.data
        if($scope.approved.length > 0){
            $scope.buttons.mas = true;
        }
        $scope.displayComments();
    });

    $scope.addComment = ($event) => {
        $event.stopPropagation();
        if($scope.comentar == undefined || $scope.comentar == ""){
            return Materialize.toast('Comentario inexistente', 4000);
        }
        $($event.target).prop('disabled', true);
        $http.post('/comments/add', {noticia: noticia_id, comentario: $scope.comentar}).then(res => {
            $($event.target).prop('disabled', false);
            if(res.data.success){
                $scope.approved = res.data.success;
                $scope.buttons.mas = true;
                $scope.displayComments($scope.comentarios.length);
            } else {
                return Materialize.toast('Error inesperado',4000);
            }
        });
    } 
});


app.controller('likeController', ($scope, $http) => {
    
    $scope.like = function(e) {
        if(!$(e).hasClass('img_selected')){
            $http.get(location.pathname+'/like').then(res => {
                if(res.data.success){
                    var success = res.data.success;
                    $("#dislike").removeClass('img_selected');
                    $("#like").addClass('img_selected');
                    $(".cant.like").text(success.likes);
                    $(".cant.dislike").text(success.dislikes);
                }
            });
        }
    }
    
    $scope.dislike = function(e) {
        if(!$(e).hasClass('img_selected')){ 
            $http.get(location.pathname+'/dislike').then(res => {
                if(res.data.success) {
                    var success = res.data.success;
                    $("#dislike").addClass('img_selected');
                    $("#like").removeClass('img_selected');
                    $(".cant.like").text(success.likes);
                    $(".cant.dislike").text(success.dislikes);
                }
            });
        }
    }

});

app.run(() => {
    
    angular.element('document').ready(function(){

        colorize()

        var color = $("#catcolor").text();

        $("#new-html").find('a').each(function(){
            $(this).css({'color':'#'+color});
        });
        
        $("#share-button").click(function(e){
            e.preventDefault();
            $("#social-popover").animate({
                'top':'-300px',
                'opacity':'1',
            });
            setTimeout(function(){
                $("#social-popover").animate({
                    'top':'0px',
                    'opacity':'0',
                });
            },4000);
        });

    });

});

function redirect(id) {
    $('input[name="id"]').val(id);
    $('#redform').submit();
}

function colorize(){
    /*$('[data-hex-bg]').each(function(c, e){
        $(e).css({'border-left':'2px solid #'+$(this).data('hex-bg')});
    })*/

    $('[data-hex-cl]').each(function(c, e){
        $(e).css({'color':'#'+$(this).data('hex-cl')});
    })
}