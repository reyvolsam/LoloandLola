@extends('layouts.master')

@section('js')
  <script type="text/javascript" src="{{ asset('statics/js/customs/product/index.js') }}"></script>
@stop

@section('content')
<div class = "row">
    <div class ="col-sm-12 col-md-6"></div>
    <div class = "col-sm-12 col-md-6 t_right">
        <button type = "button" class = "btn btn_dpilady" ng-click = "vm.OpenModalProduct();"><i class = "fa fa-plus"></i> Crear Producto</button>
        <br />
        <br />
    </div><!--/col-sm-12-->
</div><!--/row-->

<div class="row">
    <div class="col-md-12" ng-init = "vm.GetProductList()">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title t_left">Productos</h4>

                <div class="table-responsive">
                    <table class="table table-hover" ng-if = "vm.product.loader == false">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody ng-repeat = "product in vm.product.list" ng-init = "cont = $index">
                            <tr>
                                <td>@{{ product.name }}</td>
                                <td>@{{ product.price | currency }}</td>
                                <td>@{{ product.stock }}</td>
                                <td class = "icon_action">
                                    <button class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Eliminar producto" ng-click = "vm.DeleteProduct(product);"><i class="fa fa-trash"></i></button>
                                    <button class = "btn btn-link btn-xs" data-toggle = "tooltip" data-placement = "top" title = "Editar producto" ng-click = "vm.EditProduct(product);"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i ng-if = "vm.product.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                </div><!--/table-responsive-->

            </div><!--/card-body-->
        </div><!--/card-->
    </div><!-- . col-md-12 -->
</div><!--/row-->
@stop

@section('modal')
<div class = "modal fade" id = "create_product_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
        <div class = "modal-dialog" role = "document">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" ng-bind = "vm.product.modal.title"></h5>
                </div><!--/modal-header-->
                <form ng-submit = "vm.SaveProduct();">
                    <div class = "modal-body">
                        <div class = "form-group">
                            <label for = "name">Nombre</label>
                            <input ng-disabled = "vm.product.modal.loader" type = "text" class = "form-control" id = "name" name = "name" ng-model = "vm.product.modal.name" placeholder = "Nombre" />
                        </div><!--/form-group-->
                        <div class = "form-group col-md-6">
                            <label for = "price">Precio</label>
                            <div class="input-group mb-3">
                                <input ng-disabled = "vm.product.modal.loader" type = "text" class = "form-control" id = "price" name = "price" ng-model = "vm.product.modal.price" ng-currency placeholder = "Precio" />
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">MXN</span>
                                </div><!--/input-group-append-->
                            </div><!--/input-group-->
                        </div><!--/form-group-->
                        <div class = "form-group">
                            <label for = "name">Stock</label>
                            <input ng-disabled = "vm.product.modal.loader" type = "number" class = "form-control" id = "stock" name = "stock" ng-model = "vm.product.modal.stock" placeholder = "Stock" ng-change = "vm.ChangeStock()" />
                        </div><!--/form-group-->
                    </div><!--/modal-body-->
                    <div class = "modal-footer">
                        <button ng-if = "vm.product.modal.loader == false" type = "button" class = "btn btn-secondary" ng-click = "vm.CancelProductModal()">Cancelar</button>
                        <button ng-if = "vm.product.modal.loader == false" type = "submit" class = "btn btn-primary verde">Guardar Producto</button>
                        <i ng-if = "vm.product.modal.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>

                    </div><!--/modal-footer-->
                </form>
            </div><!--/modal-ontent-->
        </div><!--/modal-dialog-->
    </div><!--modal-->

@stop
