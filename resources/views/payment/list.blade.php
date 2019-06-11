@extends('layouts.master')

@section('js')
    <script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/customs/payment/list.js') }}"></script>
@stop

@section('content')
<div class = "row">
    <div class ="col-md-10">
        <div class = "row">
            <div class = "col-md-3">    
                <div class = "form-group">
                    <div class = "input-group">
                        <input type = "text" class = "form-control" id = "date_init" uib-datepicker-popup ng-model = "vm.date_init" is-open = "vm.control_init.opened" datepicker-options = "vm.control_init" ng-required = "true" close-text = "Cerrar" placeholder = "Fecha inicial" ng-change = "vm.GetPayments()" />
                        <span class = "input-group-btn">
                            <button type = "button" class = "btn btn-secondary" ng-click = "vm.control_init.opened = true">
                                <i class = "fa-svg-icon">
                                    <i class = "fa fa-calendar"></i>
                                </i>
                            </button>
                        </span><!--/input-group-btn-->
                    </div><!--/input-group-->
                </div><!--/form-group-->
            </div><!--/col-md-5-->
            <div class = "col-md-3">
                <div class = "form-group">
                    <div class = "input-group">
                        <input type = "text" class = "form-control" id = "date_final" uib-datepicker-popup ng-model = "vm.date_final" is-open = "vm.control_final.opened" datepicker-options = "vm.control_final" ng-required = "true" close-text = "Cerrar" placeholder = "Fecha final" ng-change = "vm.GetPayments()" />
                        <span class = "input-group-btn">
                            <button type = "button" class = "btn btn-secondary" ng-click = "vm.control_final.opened = true">
                                <i class = "fa-svg-icon">
                                    <i class = "fa fa-calendar"></i>
                                </i>
                            </button>
                        </span><!--/input-group-btn-->
                    </div><!--/input-group-->
                </div><!--/form-group-->
            </div><!--/col-md-5-->
        </div><!--/row-->
    </div><!--/col-sm-12-->
    <div class = "col-md-2 t_right">
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
                                <th style="width:7px; font-size:15px;color: #2c1b19;">Folio</th>
                                <th style="width:30px;font-size:15px;color: #2c1b19;">Cliente</th>
                                <th style="font-size:15px;color: #2c1b19;">Teléfono</th>
                                <th style="font-size:15px;color: #2c1b19;">Tipo de pago</th>
                                <th style="font-size:15px;color: #2c1b19;">Total</th>
                                <th style="font-size:15px;color: #2c1b19;">Anticipo</th>
                                <th style="font-size:15px;color: #2c1b19;">Descuento</th>
                                <th style="font-size:15px;color: #2c1b19;">Resta</th>
                                <th style="font-size:15px;color: #2c1b19;">Fecha de Venta</th>
							    <th style="font-size:15px;color: #2c1b19;">Fecha de Entrega</th>
                                <th></th>
                            </thead>
                            <tbody ng-repeat = "payment in vm.list.list" ng-init = "cont = $index">
                                <tr>
                                    <td style="width:7px;">@{{ payment.id }}</td>
                                    <td >@{{ payment.name }}</td>
                                    <td >@{{ payment.phone }}</td>
                                    <td>@{{ payment.payment_type.name }}</td>
                                    <td>@{{ payment.subtotal | currency }}</td>
                                    <td>@{{ payment.advance_payment | currency }}</td>
                                    <td>@{{ payment.discount.name }}</td>
                                    <td>@{{ payment.grand_total | currency }}</td>
                                    <td style="font-size:12px;">@{{ payment.created_at }}</td>
									<td style="font-size:16px;color: #fa9295; font-weight:600;">@{{ payment.delivery_date }}</td>
                                    <td>
                                        <button class = "btn btn-primary btn-xs green" ng-click = "vm.OpenServiceModal($index)"><i class = "fa fa-eye"></i></button>
                                        <button ng-if = "payment.design_image != null" class = "btn btn-primary btn-xs" ng-click = "vm.OpenDesignImageModal($index)"><i class = "fa fa-picture-o"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <i ng-if = "vm.list.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                    </div><!--/tale-responsive -->
                </div><!--/row-->

                <div ng-if = "vm.list.paginator_list.length > 1">
                    <nav ng-if = "vm.list.loader == false" aria-label="Page navigation example">
                        <ul class = "pagination justify-content-center">
                        <li ng-class = "n.style" ng-repeat = "n in vm.list.paginator_list" ng-click = "vm.list.page = $index+1; vm.GetPayments();"><a class="page-link" href="#">@{{ n.number }}</a></li>
                        </ul>
                    </nav>
                </div>
                

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
                    <div class = "col-md-5">  
                        <div class = "form-group">
                            <label for = "delivery_date">Fecha de entrega</label>
                            <input type = "text" class = "form-control" value = "@{{ vm.delivery_date }}" disabled = "disabled" />
                        </div><!--/form-group-->
                    </div><!--/col-md-5-->
                </div><!--/row-->

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

<div class = "modal fade" id = "payment_image_modal" tabindex = "-1" role = "dialog" data-backdrop = "static" data-keyboard = "false">
    <div class = "modal-dialog modal-lg" role = "document">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title" id = "add_service_modal_label">Diseño Personalizado</h5>
            </div><!--/modal-header-->
            <div class = "modal-body">
                <img src = "{{ asset('designs_images/') }}/@{{ vm.design_image }}" alt = "Diseño Personalizado" />
            </div><!--/modal-body-->
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-danger" ng-click = "vm.CloseDesignImage()">Cerrar</button>
            </div><!--/modal-footer-->
        </div><!--/modal-content-->
    </div><!--/modal-dialog-->
</div><!--/modal-->
@stop