@extends('layouts.master')

@section('js')
  <script type="text/javascript" src="{{ asset('statics/js/customs/user/index.js') }}"></script>
  <script>
      @if(\Auth::getUser()->group_id == 3)
      var label_module = 'Cliente';
      @else
      var label_module = 'Usuario'
      @endif
  </script>
@stop

@section('content')
<div class = "row">
    <div class ="col-sm-12 col-md-6"></div>
    <div class = "col-sm-12 col-md-6 t_right">
        <button type = "button" class = "btn btn_dpilady" ng-click = "vm.OpenModalUsers();">
            <i class = "fa fa-plus"></i>			
             Crear @{{vm.label_module}}
            </button>
        <br />
        <br />
    </div><!--/col-sm-12-->
</div><!--/row-->

<div class="row">
    <div class="col-md-12" ng-init = "vm.GetUsersList()">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title t_left">
                    @{{vm.label_module}}
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover" ng-if = "vm.user.loader == false">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo Electrónico</th>
                                <th>Perfil</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody ng-repeat = "user in vm.user.list" ng-init = "cont = $index">
                            <tr>
                            <td>@{{ user.first_name }} @{{ user.last_name }}</td>
                            <td>@{{ user.email }}</td>
                            <td> <span class = "badge badge-primary">@{{ user.group.alias }}</span> </td>
                                <td class = "icon_action">
                                    <button ng-if = "user.login == false" class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Editar usuario" ng-click = "vm.DeleteUser(user);"><i class="fa fa-trash"></i></button>
                                    <button ng-if = "user.login == false" class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Eliminar usuario" ng-click = "vm.EditUser(user);"><i class="fa fa-edit"></i></button>
                                    @if(\Auth::getUser()->group_id == 3 || \Auth::getUser()->group_id == 4)
                                    <button ng-if = "user.login == true" class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Cambiar contraseña" ng-click = "vm.OpenUpdatePasswordModal(user);"><i class="fa fa-key"></i></button>
                                    @endif
                                    @if(\Auth::getUser()->group_id == 1 || \Auth::getUser()->group_id == 2)
                                    <button class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Cambiar contraseña" ng-click = "vm.OpenUpdatePasswordModal(user);"><i class="fa fa-key"></i></button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i ng-if = "vm.user.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                </div><!--/table-responsive-->

            </div><!--/card-body-->
        </div><!--/card-->
    </div><!-- . col-md-12 -->
</div><!--/row-->
@stop

@section('modal')

@extends('user.create_user')

<div class = "modal fade" id = "update_password_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
    <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title">Actualizar Contraseña</h5>
            </div><!--/modal-header-->
            <form ng-submit = "vm.UpdateUserPassword()">
                <div class = "modal-body">
                    <div class = "form-group">
                        <label for = "password">Nueva Contraseña</label>
                        <input ng-disabled = "vm.user.password_modal.loader" type = "password" class = "form-control" id = "password" name = "password" ng-model = "vm.user.password_modal.password" placeholder = "Nueva Contraseña" />
                    </div><!--/form-group-->
                    <div class = "form-group">
                        <label for = "password_confirm">Confirmar Nueva Contraseña</label>
                        <input ng-disabled = "vm.user.password_modal.loader" type = "password" class = "form-control" id = "password_confirm" name = "password_confirm" ng-model = "vm.user.password_modal.password_confirm" placeholder = "Confirmar Nueva Contraseña" />
                    </div><!--/form-group-->
                </div><!--/modal-body-->
                <div class = "modal-footer">
                    <button ng-if = "vm.user.password_modal.loader == false" type = "button" class = "btn btn-secondary" ng-click = "vm.CancelPasswordModal()">Cancelar</button>
                    <button ng-if = "vm.user.password_modal.loader == false" type = "submit" class = "btn btn-primary verde">Actualizar Contraseña</button>
                    <i ng-if = "vm.user.password_modal.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                </div><!--/modal-footer-->
            </form>
        </div><!--/modal-content-->
    </div><!--/modal-dialog-->
</div><!--/modal-->
@stop
