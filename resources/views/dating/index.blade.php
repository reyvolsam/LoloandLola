@extends('layouts.master')

@section('js')
    <script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/customs/dating/index.js') }}"></script>
@stop

@section('content')
<div class="row">
    <div class="col-md-12" ng-init = "vm.InitLoad()">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title t_left">Citas</h4>

                <i ng-if = "vm.dating.tabs.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>

                <div ng-if = "vm.dating.tabs.loader == false" class = "row justify-content-md-center">
                    <div class = "col-md-3">
                        <h4>Hora inicial</h4>
                        <div uib-timepicker ng-model = "vm.dating.init_slot" hour-step = "vm.dating.config.hstep" minute-step = "vm.dating.config.mstep" show-meridian = "vm.dating.config.ismeridian"></div>
                    </div><!--/col-md-3-->
                    <div class = "col-md-3">
                        <h4>Hora final</h4>
                        <div uib-timepicker ng-model = "vm.dating.final_slot" hour-step = "vm.dating.config.hstep" minute-step = "vm.dating.config.mstep" show-meridian = "vm.dating.config.ismeridian"></div>
                    </div><!--/col-md-3-->
                </div><!--/row-->

                <div ng-if = "vm.dating.tabs.loader == false" class = "row">
                    <div class = "col-4">
                        <div class = "list-group" id = "list_dating_days" role = "tablist">
                            <a class = "list-group-item list-group-item-action active" id = "list_dating_monday" data-toggle = "list" href = "#list_monday" role ="tab" aria-controls="monday" ng-click = "vm.dating.tabs.day = 'monday'">Lunes</a>
                            <a class = "list-group-item list-group-item-action" id = "list_dating_tuesday" data-toggle = "list" href="#list_tuesday" role = "tab" aria-controls = "tuesday" ng-click = "vm.dating.tabs.day = 'tuesday'">Martes</a>
                            <a class = "list-group-item list-group-item-action" id = "list_dating_wednesday" data-toggle = "list" href="#list_wednesday" role = "tab" aria-controls = "wednesday" ng-click = "vm.dating.tabs.day = 'wednesday'">Miercoles</a>
                            <a class = "list-group-item list-group-item-action" id = "list_dating_thursday" data-toggle = "list" href="#list_thursday" role = "tab" aria-controls = "thursday" ng-click = "vm.dating.tabs.day = 'thursday'">Jueves</a>
                            <a class = "list-group-item list-group-item-action" id = "list_dating_friday" data-toggle = "list" href="#list_friday" role = "tab" aria-controls = "friday" ng-click = "vm.dating.tabs.day = 'friday'">Viernes</a>
                            <a class = "list-group-item list-group-item-action" id = "list_dating_saturday" data-toggle = "list" href="#list_saturday" role = "tab" aria-controls = "saturday" ng-click = "vm.dating.tabs.day = 'saturday'">Sabado</a>
                            <a class = "list-group-item list-group-item-action" id = "list_dating_sunday" data-toggle = "list" href="#list_sunday" role = "tab" aria-controls = "sunday" ng-click = "vm.dating.tabs.day = 'sunday'">Domingo</a>
                        </div><!--/list-group-->
                    </div><!--/col-4-->
                    <div class="col-8">
                        <div class="tab-content" id="nav-tabContent">
                            <div class = "tab-pane fade show active" id = "list_monday" role = "tabpanel" aria-labelledby="list_dating_monday_list">
                                <h4>Lunes</h4>
                                
                                <i ng-if = "vm.dating.tabs.monday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.monday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.monday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_monday-->
                            <div class = "tab-pane fade" id = "list_tuesday" role = "tabpanel" aria-labelledby = "list_dating_tuesday_list">
                                <h4>Martes</h4>

                                <i ng-if = "vm.dating.tabs.tuesday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.tuesday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.tuesday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_tuesday-->
                            <div class = "tab-pane fade" id = "list_wednesday" role = "tabpanel" aria-labelledby = "list_dating_wednesday_list">
                                <h4>Miercoles</h4>

                                <i ng-if = "vm.dating.tabs.wednesday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.wednesday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.wednesday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_wednesday-->
                            <div class = "tab-pane fade" id = "list_thursday" role = "tabpanel" aria-labelledby = "list_dating_thursday_list">
                                <h4>Jueves</h4>

                                <i ng-if = "vm.dating.tabs.thursday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.thursday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.thursday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_thursday-->
                            <div class = "tab-pane fade" id = "list_friday" role = "tabpanel" aria-labelledby = "list_dating_friday_list">
                                <h4>Viernes</h4>

                                <i ng-if = "vm.dating.tabs.friday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.friday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.friday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_friday-->
                            <div class = "tab-pane fade" id = "list_saturday" role = "tabpanel" aria-labelledby = "list_dating_saturday_list">
                                <h4>Sabado</h4>

                                <i ng-if = "vm.dating.tabs.saturday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.saturday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.saturday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_saturday-->
                            <div class = "tab-pane fade" id = "list_sunday" role = "tabpanel" aria-labelledby = "list_dating_sunday_list">
                                <h4>Domingo</h4>

                                <i ng-if = "vm.dating.tabs.sunday.loader == true" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                
                                <div ng-if = "vm.dating.tabs.sunday.loader == false">
                                    <button class = "btn btn-secondary btn-sm justify-content-md-center" ng-click = "vm.AddSchedule()"> <i class = "fa fa-plus"></i> Agregar</button>
                                    <div class = "clearfix"></div>
                                    <br />

                                    <span ng-repeat = "day in vm.dating.tabs.sunday.list" class = "badge badge-pill badge-info">@{{ day.init_slot}} - @{{ day.final_slot }} <i class = "fa fa-close" ng-click = "vm.DeleteSlot(day.id)"></i></span>
                                </div>
                            </div><!--/list_dating_saturday-->
                        </div><!--/tab-content-->
                    </div><!--/col-8-->
                </div><!--/row-->
                <br />
                <br />
                <h4 class="card-title t_left">Fecha sin citas</h4>

                <div class = "row">
                    <div class = "col-md-6">
                        <p class = "input-group">
                            <input ng-disabled = "vm.dating.exceptions.loader"  type = "text" class = "form-control" uib-datepicker-popup ng-model = "vm.dating.exceptions.date" is-open = "vm.date_control.opened" datepicker-options = "vm.date_control" ng-required = "true" close-text = "Cerrar" />
                            <span class = "input-group-btn">
                                <button ng-disabled = "vm.dating.exceptions.loader" type = "button" class = "btn btn-secondary" ng-click = "vm.date_control.opened = true">
                                    <i class = "fa-svg-icon">
                                        <i class = "fa fa-calendar"></i>
                                    </i>
                                </button>
                            </span><!--/input-group-btn-->
                        </p>
                    </div><!--/col-md-6-->
                    <div class = "clearfix"></div>
                    <br />
                    <div class="col-md-12">
                        <button ng-disabled = "vm.dating.exceptions.loader" class = "btn btn-success pull-left" ng-click = "vm.AddDate()"> 
                            <span ng-if = "vm.dating.exceptions.loader == true"><i class = "fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i></span>
                            <span ng-if = "vm.dating.exceptions.loader == false">Agregar</span>
                        </button>
                    </div><!--/col-md-6-->
                </div><!--/row-->


                <table class = "table">
                    <thead>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </thead>
                    <tbody ng-repeat = "date in vm.dating.exceptions.list" ng-init = "cont = $index">
                        <tr>
                        <td>@{{ $index+1 }}</td>
                        <td>@{{ date.date }}</td>
                        <td>
                            <button type = "button" class = "btn btn-danger btn-xs" ng-click = "vm.DeleteExceptionDate(date.id)"><i class = "fa fa-trash"></i></button>
                        </td>
                        </tr>
                    </tbody>
                </table>
                <i ng-if = "vm.dating.exceptions.list_loader == true" class = "fa fa-circle-o-notch fa-2x fa-fw"></i>

            </div><!--card-body-->
        </div><!--/card-->
    </div><!--/col-md-12-->
</div><!--/row-->
@stop