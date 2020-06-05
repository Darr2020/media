<div id="media" class="col s12">
    <div class="padding">
        <div class="row section">
            <div class="col s12 m4 l3">
                <div class="card gradient-45deg-light-blue-cyan gradient-shadow">
                    <div class="card-content white-text">
                        <span class="card-title">Portada</span>
                        <p>Cargar una imagen que tenga las dimensiones de mínimo <span class="gradient-45deg-purple-deep-orange-text"><b>1200x800...</b></span>, un peso de máximo <span class="gradient-45deg-purple-deep-orange-text"><b>2MB</b></span></p>
                    </div>
                </div>
                <span ng-show="portada == null" class="error-view">Portada requerida</span>
            </div>
            <div class="col s12 m8 l9">
                <input type="file" id="portada" ng-model="portada" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="png jpg jpeg"/>
            </div>
        </div>
        <div class="divider"></div>
    </div>
</div>