
        CKEDITOR.height = 1000
        CKEDITOR.config.language = 'es'
        CKEDITOR.replace('contenido')
        
        DROPIFY = $("#portada").dropify()

        DROPIFY.on('dropify.afterClear', (event, element) => {
            var $scope = angular.element('div#nuevaNoticiaApp').scope()
            $scope.$apply(function(){
                $scope.portada = null
            })
        })

        $('#portada').on('change', function(event){
            var $scope = angular.element('div#nuevaNoticiaApp').scope()
            var file = $(this).prop('files')[0]
            $scope.$apply(function(){
                $scope.portada = file
            })
        })

        Dropzone.options.imagesDropzone = {
            paramName: "file",
            maxFilesize: 1,
            withCredentials: true,
            maxFiles: 4,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictDefaultMessage: 'Cargar Imagenes y Videos',
            dictFallBackMessage:'El Navegador no es soportado',
            dictFileTooBig: 'El archivo proporcionado es muy pesado',
            dictInvalidFileType: 'El archivo no es del tipo correcto',
            dictResponseError: 'Error @{{statusCode}} de Servidor',
            dictCancelUpload: 'Cancelar',
            dictUploadCanceled: 'Cancelado...',
            dictRemoveFile: 'Borrar Archivo',
            dictMaxFilesExceeded: 'Cantidad maxima de archivos superada',
            init: function(){
                
                this.on('addedfile', async file => {
                    await isAccepted(file)
                })
                
                this.on("removedfile", file =>  {
                    var $scope = angular.element('div.container').scope()
                    $scope.images.map((im, index) => {
                        if(im.upload.filename == file.upload.filename)
                            $scope.$apply(function(scope){
                                $scope.images.splice(index,1)
                            })
                    })
                })
            }
        };

        function isAccepted(file) {
            setTimeout(function(){
                if(file.accepted) {
                    var $scope = angular.element('div.container').scope()
                    $scope.$apply(function(scope){
                        scope.images.push(file)
                    })
                }
            }, 100)
        }

        function deleteTag(code) {
            var scope = angular.element('div.container').scope()
            scope.$apply(function($scope){
                var index
                
                $scope.tags.map((e, c) => {
                    if(e.number == code)
                        return index = c
                })

                $scope.tags.splice(index);

                $('span[data-delete="'+code+'"]').fadeOut(function(){
                    $(this).remove()
                })
            })
        }

        app.controller('noticiaController', ($scope, $http) => {

            $scope.tags = []
            
            $http.get('/api/tags').then(res => {
                $scope.t = res.data
            })

            $scope.contenido = null
            $scope.portada = null

            $scope.saveForm = $event => {

                try {
                    
                    $event.stopPropagation()
                    $scope.validateForm()
                    $scope.validateTitlePosition()
                    $scope.hasTags()
                    $scope.hasMainContent()
                    $scope.hasMainImage()
                    Materialize.toast('Espere...', 4000);
                    $scope.save()

                } catch(err) {    
                    swal((String(err.message)).toUpperCase(), '', 'warning').then(sal => {
                        err.action()
                    });
                }

            }

            $scope.validateTitlePosition = () => {
                if(!$scope.title_position)
                    throw {
                        message: 'No se ha elegido la posición del titulo', 
                        action: () => $('a[href="#publicacion"').click()
                    }
            }

            $scope.addTag = $event => {
                
                try {
                    $event.stopPropagation()
                    var name = $("#tag-input").val().replace(/ /g,'') || null;
                    var zone = $("#tagDumper")
                    var tags = zone.find('span')

                    if(!name){
                        throw 'Llenar el input de tag'
                    }

                    tags.each(function(e, v) {
                        if(this.innerHTML.toLowerCase() == name.toLowerCase()){
                            throw 'Tag ya fue seleccionado'
                        }
                    })

                    $scope.tags.push({number: tags.length, tag: name});
                    
                    var el = $('<span data-delete="'+tags.length+'" onclick=deleteTag("'+tags.length+'")>'+name+'</span>')
                    var el = zone.append(el).find('span')

                    el.animate({opacity:1}, 500)
                } catch(e) {
                    swal('ERROR', e, 'error')
                }
            }

            $scope.validateForm = () => {
                $scope.inputs = $(".validate");
                $scope.inputs.each(function(){
                    if(this.value == "")
                        throw {
                            message: 'Faltan valores por llenar', 
                            action: () => $('a[href="#publicacion"').click()
                        }
                })
            }

            $scope.hasMainImage = () => {
                if(!$scope.portada)
                    throw {
                        message: 'Falta una foto de portada', 
                        action: () => $('a[href="#media"').click()
                    }
            }

            $scope.hasMainContent = () => {
                $scope.contenido = CKEDITOR.instances.contenido.getData()
                if(!$scope.contenido)
                    throw {
                        message: 'No se ha cargado un contenido de la noticia', 
                        action: () => $('a[href="#publicacion"').click()
                    }
            }

            $scope.hasGallery = () => {
                if(!$scope.images.length > 0)
                    throw {
                        message: 'No se ha cargado ni una imagen para la galeria', 
                        action: () => $('a[href="#media"').click()
                    }
            }

            $scope.hasTags = () => {
                if($scope.tags.length <= 0){
                    throw {
                        message: 'No se han seleccionado tags', 
                        action: () => $('a[href="#publicacion"').click()
                    }
                }
            }

            $scope.save = () => {
                
                var form_data = new FormData()
                
                form_data.append('contenido', $scope.contenido)
                form_data.append('titulo', $scope.titulo)
                form_data.append('categoria', $scope.categoria)
                form_data.append('portada', $scope.portada)
                form_data.append('descripcion', $scope.descripcion)
                form_data.append('title_position', $scope.title_position)
                
                $.each($scope.tags, (p, el) => {
                    form_data.append('tag['+el.number+']', el.tag)
                })

                $.each($scope.images, (p, el) => {
                    form_data.append('images['+p+']', el)
                })
    
                $.ajax({
                    url: '/backend/guardarNoticia',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: data => {
                        if(data.success){
                            swal(data.success, 'Espere que su noticia sea publicada...', 'success')
                            setTimeout(() => {
                                location.href = '/backend/inicio';
                            }, 1500)
                        }              
                    }
                })
            }

        })