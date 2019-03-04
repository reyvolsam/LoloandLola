@extends('layouts.master')

@section('js')
    <script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/customs/payment/list.js') }}"></script>
@stop

@section('content')
<div class = "row">
    <div class ="col-sm-12 col-md-6">
        <div class = "col-md-5">
            <div class = "form-group">
                <div class = "input-group">
                    <input type = "text" class = "form-control" id = "cita_date" uib-datepicker-popup ng-model = "vm.cita.date" is-open = "vm.date_control.opened" datepicker-options = "vm.date_control" ng-required = "true" close-text = "Cerrar" placeholder = "Seleccione una fecha" ng-change = "vm.GetPayments()" />
                    <span class = "input-group-btn">
                        <button type = "button" class = "btn btn-secondary" ng-click = "vm.date_control.opened = true">
                            <i class = "fa-svg-icon">
                                <i class = "fa fa-calendar"></i>
                            </i>
                        </button>
                    </span><!--/input-group-btn-->
                </div><!--/input-group-->
            </div><!--/form-group-->
        </div><!--/col-md-3-->
    </div>
    <div class = "col-sm-12 col-md-6 t_right">
        <a href = "{{ URL::to('payment2') }}" class = "btn btn_dpilady"><i class = "fa fa-credit-card"></i> Pagar</a>
        <br />
        <br />
    </div><!--/col-sm-12-->
</div><!--/row-->
<div class="row" ng-init = "vm.GetPayments()">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title t_left">Historial de Pagos | Total: <span class="badge badge-secondary">@{{ vm.list.total_payment | currency}}</span></h4>

                <div class = "row">
                    <div class="table-responsive">
                        <table class = "table">
                            <thead>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Fecha de Cita</th>
                                <th>Horario</th>
                                <th>Tipo de pago</th>
                                <th>Subtotal</th>
                                <th>Descuento</th>
                                <th>Total</th>
                                <th>Fecha de Venta</th>
                                <th></th>
                            </thead>
                            <tbody ng-repeat = "payment in vm.list.list" ng-init = "cont = $index">
                                <tr>
                                    <td>@{{ payment.id }}</td>
                                    <td>@{{ payment.user_slot.name }}</td>
                                    <td>@{{ payment.user_slot.date }}</td>
                                    <td>@{{ payment.user_slot.init_slot }} - @{{ payment.user_slot.final_slot }}</td>
                                    <td>@{{ payment.payment_type.name }}</td>
                                    <td>@{{ payment.total | currency }}</td>
                                    <td>@{{ payment.discount.name }}</td>
                                    <td>@{{ payment.grand_total | currency }}</td>
                                    <td>@{{ payment.created_at }}</td>
                                    <td>
                                        <button class = "btn btn-primary btn-xs" ng-click = "vm.OpenServiceModal($index)"><i class = "fa fa-list"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <i ng-if = "vm.list.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                    </div><!--/tale-responsive -->
                </div><!--/row-->

                
                <nav ng-if = "vm.list.loader == false" aria-label="Page navigation example">
                    <ul class = "pagination justify-content-center">
                    <li ng-class = "n.style" ng-repeat = "n in vm.list.paginator_list" ng-click = "vm.list.page = $index+1; vm.GetPayments();"><a class="page-link" href="#">@{{ n.number }}</a></li>
                    </ul>
                </nav>
                

            </div><!--/card-body-->
        </div><!--/card-->
    </div><!--/col-md-12-->
</div><!--/row-->
@stop


@section('modal')
<div class = "modal fade" id = "service_list_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
    <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title" id = "add_service_modal_label">Lista de servicios</h5>
            </div><!--/modal-header-->
            <div class = "modal-body">
                <div class = "row">
                    <table class = "table">
                        <thead>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </thead>
                        <tbody ng-repeat = "service in vm.service_list" ng-init = "cont = $index">
                            <tr>
                                <td>@{{ service.service.name }}</td>
                                <td>@{{ service.service.price | currency }}</td>
                                <td>@{{ service.quantity }}</td>
                                <td>@{{ service.total | currency }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--/row-->

                <div class = "row">
                    <table class = "table">
                        <thead>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </thead>
                        <tbody ng-repeat = "product in vm.product_list" ng-init = "cont = $index">
                            <tr>
                                <td>@{{ product.product.name }}</td>
                                <td>@{{ product.product.price | currency }}</td>
                                <td>@{{ product.quantity }}</td>
                                <td>@{{ product.total | currency }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--/row-->

                <button class = "btn btn-danger" data-dismiss="modal" >Cerrar</button>
            </div><!--/modal-body-->
        </div><!--/modal-content-->
    </div><!--/moal-dialog-->
</div><!--/add_service_modal-->