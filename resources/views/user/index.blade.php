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
                                <th>Perfil</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody ng-repeat = "user in vm.user.list" ng-init = "cont = $index">
                            <tr>
                            <td>@{{ user.first_name }} @{{ user.last_name }}</td>
                            <td> <span class = "badge badge-primary">@{{ user.group.alias }}</span> </td>
                                <td class = "icon_action">
                                    <button ng-if = "user.login == false" class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Editar usuario" ng-click = "vm.DeleteUser(user);"><i class="fa fa-trash"></i></button>
                                    <button ng-if = "user.login == false" class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Eliminar usuario" ng-click = "vm.EditUser(user);"><i class="fa fa-edit"></i></button>
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
<div class = "modal fade" id = "create_user_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
        <div class = "modal-dialog" role = "document">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" ng-bind = "vm.user.modal.title"></h5>
                </div><!--/modal-header-->
                <form ng-submit = "vm.SaveUser();">
                    <div class = "modal-body">
                        <div class = "form-group">
                            <label for = "first_name">Nombre</label>
                            <input ng-disabled = "vm.user.modal.loader" type = "text" class = "form-control" id = "first_name" name = "first_name" ng-model = "vm.user.modal.first_name" placeholder = "Nombre" />
                        </div><!--/form-group-->
                        <div class = "form-group">
                            <label for = "last_name">Apellidos</label>
                            <input ng-disabled = "vm.user.modal.loader" type = "text" class = "form-control" id = "last_name" name = "last_name" ng-model = "vm.user.modal.last_name" placeholder = "Apellidos" />
                        </div><!--/form-group-->
                        <div class = "form-group">
                            <label for = "email">Correo Electrónico</label>
                            <input ng-disabled = "vm.user.modal.loader" type = "email" class = "form-control" id = "email" name = "email" ng-model = "vm.user.modal.email" placeholder = "Correo Electrónico" />
                        </div><!--/form-group-->
                        @if(\Auth::getUser()->group_id != 3)
                        <div class = "form-group">
                            <label for = "profile">Perfil</label>
                            <select ng-disabled = "vm.user.modal.loader" class = "form-control" id = "profile" name = "profile" ng-model = "vm.user.modal.group_id" ng-options = "p_list.id as p_list.alias for p_list in vm.profiles_list">
                                <option value = "">Elije un perfil...</option>
                            </select>
                        </div><!--/form-group-->
                        @endif
                        <div class = "form-group">
                            <div class = "custom-control custom-switch">
                                <input ng-disabled = "vm.user.modal.loader" type = "checkbox" class = "custom-control-input" id = "customSwitch1" ng-model = "vm.user.modal.active" />
                                <label class = "custom-control-label" for = "customSwitch1">Activo</label>
                            </div>
                        </div>

                    </div><!--/modal-body-->
                    <div class = "modal-footer">
                        <button ng-if = "vm.user.modal.loader == false" type = "button" class = "btn btn-secondary" ng-click = "vm.CancelUserModal()">Cancelar</button>
                    <button ng-if = "vm.user.modal.loader == false" type = "submit" class = "btn btn-primary verde">Guardar @{{vm.label_module}}</button>
                        <i ng-if = "vm.user.modal.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                    </div><!--/modal-footer-->
                </form>
            </div><!--/modal-ontent-->
        </div><!--/modal-dialog-->
    </div><!--modal-->

@stop
