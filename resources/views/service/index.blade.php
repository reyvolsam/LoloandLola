@extends('layouts.master')

@section('js')
  <script type="text/javascript" src="{{ asset('statics/js/customs/service/index.js') }}"></script>
@stop

@section('content')
<div class = "row">
    <div class ="col-sm-12 col-md-6"></div>
    <div class = "col-sm-12 col-md-6 t_right">
        <button type = "button" class = "btn btn_dpilady" ng-click = "vm.OpenModalService();"><i class = "fa fa-plus"></i> Crear Servicio</button>
        <br />
        <br />
    </div><!--/col-sm-12-->
</div><!--/row-->

<div class="row">
    <div class="col-md-12" ng-init = "vm.GetServicesList()">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title t_left">Servicios</h4>

                <div class="table-responsive">
                    <table class="table table-hover" ng-if = "vm.service.loader == false">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody ng-repeat = "service in vm.service.list" ng-init = "cont = $index">
                            <tr>
                            <td>@{{ service.name }}</td>
                            <td>@{{ service.price | currency }}</td>
                                <td class = "icon_action">
                                    <button class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Eliminar servicio" ng-click = "vm.DeleteService(service);"><i class="fa fa-trash"></i></button>
                                    <button class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Editar servicio" ng-click = "vm.EditService(service);"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i ng-if = "vm.service.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                </div><!--/table-responsive-->

            </div><!--/card-body-->
        </div><!--/card-->
    </div><!-- . col-md-12 -->
</div><!--/row-->
@stop

@section('modal')
<div class = "modal fade" id = "create_service_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
        <div class = "modal-dialog" role = "document">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" ng-bind = "vm.service.modal.title"></h5>
                </div><!--/modal-header-->
                <form ng-submit = "vm.SaveService();">
                    <div class = "modal-body">
                        <div class = "form-group">
                            <label for = "name">Nombre</label>
                            <input ng-disabled = "vm.service.modal.loader" type = "text" class = "form-control" id = "name" name = "name" ng-model = "vm.service.modal.name" placeholder = "Nombre" />
                        </div><!--/form-group-->
                        <div class = "form-group col-md-6">
                            <label for = "price">Precio</label>
                            <div class="input-group mb-3">
                                <input ng-disabled = "vm.service.modal.loader" type = "text" class = "form-control" id = "price" name = "price" ng-model = "vm.service.modal.price" ng-currency placeholder = "Precio" />
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">MXN</span>
                                </div><!--/input-group-append-->
                            </div><!--/input-group-->
                        </div><!--/form-group-->
                    </div><!--/modal-body-->
                    <div class = "modal-footer">
                        <button ng-if = "vm.service.modal.loader == false" type = "button" class = "btn btn-secondary" ng-click = "vm.CancelServiceModal()">Cancelar</button>
                        <button ng-if = "vm.service.modal.loader == false" type = "submit" class = "btn btn-primary verde">Guardar Servicio</button>
                        <i ng-if = "vm.service.modal.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>

                    </div><!--/modal-footer-->
                </form>
            </div><!--/modal-ontent-->
        </div><!--/modal-dialog-->
    </div><!--modal-->

@stop
