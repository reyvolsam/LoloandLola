@extends('layouts.master')

@section('css')
<style>

</style>
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/customs/payment/index.js') }}"></script>
@stop

@section('content')
<div class="row" ng-init = "vm.Inint()">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cliente </h4> <br>

                    <button ng-if = "vm.payment.fill_type == 0" class = "btn btn-secondary" ng-click = "vm.SwitchClientFill()"> <i class = "fa fa-user"></i> Seleccionar cliente</button>
                    <button ng-if = "vm.payment.fill_type == 1" class = "btn btn-secondary" ng-click = "vm.SwitchClientFill()"> <i class = "fa fa-user"></i> Llenar información del cliente</button>

                    <div ng-if = "vm.payment.fill_type == 1" class = "form-group">
                        <label for = "cita_date">Fecha</label>
                        <div class = "input-group">
                            <input ng-disabled = "vm.cita_date.disabled" type = "text" class = "form-control" id = "cita_date" uib-datepicker-popup ng-model = "vm.cita.date" is-open = "vm.date_control.opened" datepicker-options = "vm.date_control" ng-required = "true" close-text = "Cerrar" placeholder = "Seleccione una fecha" ng-change = "vm.GetCitasByDate()" />
                            <span class = "input-group-btn">
                                <button type = "button" class = "btn btn-secondary" ng-click = "vm.date_control.opened = true">
                                    <i class = "fa-svg-icon">
                                        <i class = "fa fa-calendar"></i>
                                    </i>
                                </button>
                            </span><!--/input-group-btn-->
                        </div><!--/input-group-->
                    </div><!--/form-group-->
                    <p ng-if = "vm.payment.fill_type == 0"><b>Campos Requeridos <span class="text-danger">*</span></b></p>

                    <div class = "form-group">
                        <label for = "client_name">Nombre del cliente<span ng-if = "vm.payment.fill_type == 0" class="text-danger">*</span></label>
                        <input ng-disabled = "vm.client_name.disabled" type = "text" class = "form-control" id = "client_name" aria-describedby = "client_name" placeholder = "Nombre del cliente" ng-model = "vm.payment.client.name" disabled = "disabled" />
                    </div><!--/form-group-->
                    <div class="form-group">
                        <label for = "date">Fecha de la cita<span ng-if = "vm.payment.fill_type == 0" class="text-danger">*</span></label>
                        <input ng-disabled = "vm.client_date.disabled" type = "text" class = "form-control" id = "date" aria-describedby = "date" placeholder = "Fecha de la cita" ng-model = "vm.payment.client.date" disabled = "disabled" />
                    </div><!--/form-group-->
                    <div class="form-group" ng-if = "vm.payment.fill_type == 1">
                        <label for = "schedule_date">Horario de la cita</label>
                        <input ng-disabled = "vm.client_schedule.disabled" type = "text" class = "form-control" id = "schedule_date" aria-describedby = "schedule_date" placeholder = "Horario de la cita" ng-model = "vm.payment.client.schedule"  disabled = "disabled" />
                    </div><!--/form-group-->

                    <div class="form-group" ng-if = "vm.payment.fill_type == 0">
                        <label for = "schedule_date_init">Hora inicial</label>
                        <input ng-disabled = "vm.client_schedule.disabled" type = "text" class = "form-control" id = "schedule_date" aria-describedby = "schedule_date" placeholder = "Horario de la cita" ng-model = "vm.payment.client.init_slot"  disabled = "disabled" />
                    </div><!--/form-group-->
                    <div class="form-group" ng-if = "vm.payment.fill_type == 0">
                            <label for = "schedule_date">Hora final</label>
                            <input ng-disabled = "vm.client_schedule.disabled" type = "text" class = "form-control" id = "schedule_date" aria-describedby = "schedule_date" placeholder = "Horario de la cita" ng-model = "vm.payment.client.final_slot"  disabled = "disabled" />
                        </div><!--/form-group-->

                    <div class = "table-responsive">
                        <table class = "table">
                            <thead>
                                <th>Servicio</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th></th>
                            </thead>
                            <tbody ng-repeat = "service in vm.payment.service_list" ng-init = "cont = $index">
                                <tr>
                                    <td>@{{ service.name }}</td>
                                    <td>@{{ service.price | currency }}</td>
                                    <td> 
                                        <input ng-disabled = "vm.payment.loader" type = "number" class = "form-control form-control-sm" ng-model = "service.quantity" ng-change = "vm.ChangeQuantityService($index)" />
                                    </td>
                                    <td>@{{ service.total | currency }}</td>
                                    <td>
                                        <button ng-disabled = "vm.payment.loader" class = "btn btn-danger btn-sm" ng-click = "vm.RemoveServiceFromPayment($index)"><i class = "fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--/table-responsive-->

                    <div class="form-group">
                        <label for = "total_service_payment">Total servicios</label>
                        <input type = "text" class = "form-control" id = "total_service_payment" aria-describedby = "total_service_payment" value = "@{{ vm.payment.total_service | currency }}"  disabled = "disabled" />
                    </div><!--/form-group-->

                    <button ng-disabled = "vm.payment.loader" class = "btn btn-success" ng-click = "vm.AddServiceModal()"><i class = "fa fa-plus"></i> Agregar servicio</button>

                    <br />
                    <br />

                    <div class = "table-responsive">
                        <table class = "table">
                            <thead>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th></th>
                            </thead>
                            <tbody ng-repeat = "product in vm.payment.product_list" ng-init = "cont = $index">
                                <tr>
                                    <td>@{{ product.name }}</td>
                                    <td>@{{ product.price | currency }}</td>
                                    <td> 
                                        <input ng-disabled = "vm.payment.loader" type = "number" class = "form-control form-control-sm" ng-model = "product.quantity" ng-change = "vm.ChangeQuantityProduct($index)" />
                                    </td>
                                    <td>@{{ product.total | currency }}</td>
                                    <td>
                                        <button ng-disabled = "vm.payment.loader" class = "btn btn-danger btn-sm" ng-click = "vm.RemoveProductFromPayment($index)"><i class = "fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--/table-responsive-->

                    <div class="form-group">
                        <label for = "total_product_payment">Total productos</label>
                        <input type = "text" class = "form-control" id = "total_product_payment" aria-describedby = "total_service_product" value = "@{{ vm.payment.total_product | currency }}"  disabled = "disabled" />
                    </div><!--/form-group-->
    
                    <button ng-disabled = "vm.payment.loader" class = "btn btn-success" ng-click = "vm.AddProductModal()"><i class = "fa fa-plus"></i> Agregar producto</button>

            </div><!--/card-body-->
        </div><!--/card-->
    </div><!-- col-md-5 -->

    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for = "subtotal_payment">Subtotal</label>
                    <input type = "text" class = "form-control" id = "subtotal_payment" aria-describedby = "subtotal_payment" value = "@{{ vm.payment.subtotal | currency }}"  disabled = "disabled" />
                </div><!--/form-group-->
                <div class="form-group">
                    <label for = "discount_payment">Descuento</label>
                    <select ng-disabled = "vm.payment.loader" class = "form-control" id = "discount_payment" name = "discount_payment" ng-model = "vm.payment.discount_id" ng-options = "d_list.id as d_list.name for d_list in vm.discount_list" ng-change = "vm.ChangeDiscount()">
                        <option value = "">Sin descuento</option>
                    </select>
                </div><!--/form-group-->
    
                <div class="form-group">
                    <label for = "payment_type">Tipo de pago</label>
                    <select ng-disabled = "vm.payment.loader" class = "form-control" id = "payment_type" name = "payment_type" ng-model = "vm.payment.type_id" ng-options = "p_list.id as p_list.name for p_list in vm.payment_type_list" ng-change = "vm.ChangeDiscount()">
                        <option value = "">Seleccione un opcion...</option>
                    </select>
                </div><!--/form-group-->
            </div><!--/card-body-->
        </div><!--/card-->

        <div class = "card pago">
            <div class = "card-body">
                <h4 class = "card-title">Pago</h4> <br>
    
                <div class = "calc">
                    <h1 class = "t_center">Total:</h1>
                <h1 class = "t_center"><strong>@{{ vm.payment.grand_total | currency }}</strong></h1>
                </div><!--/calc-->
                <br />
    
                <div class = "calc">
                    <h1 class = "t_center"></h1>
                    <div class = "form-group">
                        <label class="sr-only">Monto:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div><!--/input-group-prepend-->
                            <input ng-disabled = "vm.payment.grand_total == 0 || vm.payment.loader" type = "text" class="form-control" id = "payment_with" placeholder = "Paga con" ng-model = "vm.payment.payment_with" ng-change = "vm.ChangePaymentWith()" ng-currency />
                        </div><!--/input-group-->
                    </div><!--/form-group-->
                </div><!--/calc-->
                <br>
    
                <div class="calc_cambio">
                    <h1 class="t_center">Cambio:</h1>
                <h1 class="t_center"><strong>@{{ vm.payment.exchange | currency }}</strong></h1>
                </div><!--/calc_cambio-->
                <br><br>
                <button ng-disabled = "vm.payment.loader" class = "btn btn-danger btn-lg" ng-click = "vm.CancelPayment()">Cancelar</button>
                <button ng-dissabled = "vm.payment.loader" ng-if = "vm.payment.type_id != null" type = "submit" class = "btn btn-success btn-lg" ng-click = "vm.MakeCharge()"><i class = "fa fa-credit-card"></i> COBRAR</button>
            </div><!--/card-body-->
        </div><!--/card-->
    </div><!--/col-md-7-->

</div><!--/row-->
@stop

@section('modal')
<div class = "modal fade" id = "add_service_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
    <div class = "modal-dialog modal-lg" role = "document">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title" id = "add_service_modal_label">Seleccionar servicio</h5>
            </div><!--/modal-header-->
            <div class = "modal-body">
                <div class = "row justify-content-md-center">
                        <i ng-if = "vm.payment.service_loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                </div><!--/row-->
                    
                <div ng-if = "vm.payment.service_loader == false" class = "row">
                    <table class = "table">
                        <thead>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </thead>
                        <tbody ng-repeat = "service in vm.service_list" ng-init = "cont = $index">
                            <tr>
                                <td>@{{ service.name }}</td>
                                <td>@{{ service.price | currency }}</td>
                                <td>
                                    <button ng-if = "service.selected == false" class = "btn btn-success" ng-click = "vm.AddServiceToPayment($index)"><i class = "fa fa-check"></i></button>
                                    <button ng-if = "service.selected == true" class = "btn btn-success"><i class = "fa fa-remove"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--/row-->
            </div><!--/modal-body-->
        </div><!--/modal-content-->
    </div><!--/moal-dialog-->
</div><!--/add_service_modal-->

<div class = "modal fade" id = "add_product_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
        <div class = "modal-dialog modal-lg" role = "document">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" id = "add_product_modal_label">Seleccionar producto</h5>
                </div><!--/modal-header-->
                <div class = "modal-body">
                    <div class = "row justify-content-md-center">
                            <i ng-if = "vm.payment.product_loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                    </div><!--/row-->
                        
                    <div ng-if = "vm.payment.product_loader == false" class = "row">
                        <table class = "table">
                            <thead>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acción</th>
                            </thead>
                            <tbody ng-repeat = "product in vm.product_list" ng-init = "cont = $index">
                                <tr>
                                    <td>@{{ product.name }}</td>
                                    <td>@{{ product.price | currency }}</td>
                                    <td>@{{ product.stock }}</td>
                                    <td>
                                        <button ng-if = "product.selected == false" class = "btn btn-success" ng-click = "vm.AddProductToPayment($index)"><i class = "fa fa-check"></i></button>
                                        <button ng-if = "product.selected == true" class = "btn btn-success"><i class = "fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--/row-->
                </div><!--/modal-body-->
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" ng-click = "vm.CancelSelectProduct()">Cancelar</button>
                </div><!--/modal-footer-->
            </div><!--/modal-content-->
        </div><!--/moal-dialog-->
    </div><!--/add_service_modal-->

<div class = "modal fade" id = "slot_citas_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
        <div class = "modal-dialog" role = "document">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" id = "slot_citas_label">Selecciona cita</h5>
                </div><!--/modal-header-->
                <div class = "modal-body">
                    <div class = "row justify-content-md-center">
                            <i ng-if = "vm.cita.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                    </div><!--/row-->
                        
                    <div ng-if = "vm.cita.loader == false" class = "row">

                            <table class = "table">
                                <thead class="thead-dark">
                                    <th></th>
                                    <th>Horario</th>
                                    <th>Cliente</th>
                                    <th></th>
                                </thead>
                                <tbody ng-repeat = "cita in vm.cita.slots_list" ng-init = "cont = $index">
                                    <tr ng-class = "($index % 2 === 0) ? 'table-active' : ''">
                                        <td><b>#@{{ $index+1 }}</b></td>
                                        <td><b>@{{ cita.init_slot }} - @{{ cita.final_slot }}</b></td>
                                        <td><b>@{{ cita.client_name }}</b></td>
                                        <td><button ng-if = "cita.exist_cita == true" class = "btn btn-success" ng-click = "vm.SelectClient($index)"><i class = "fa fa-check"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>

                    </div><!--/row-->
                </div><!--/modal-body-->
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" ng-click = "vm.CancelSelectClient()">Cancelar</button>
                </div><!--/modal-footer-->
            </div><!--/modal-content-->
        </div><!--/moal-dialog-->
    </div><!--/add_service_modal-->
@stop