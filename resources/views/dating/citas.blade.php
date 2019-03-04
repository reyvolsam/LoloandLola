@extends('layouts.master')

@section('js')
    <script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/customs/dating/citas.js') }}"></script>
@stop

@section('content')
<div class="row">
    <div class="col-md-12" ng-init = "vm.InitLoad()">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title t_left">Agendar Cita</h4>

                <div class = "row">
                    <div class = "col-md-3">
                        <div class = "form-group">
                            <label for = "cita_date">Fecha</label>
                            <div class = "input-group">
                                <input type = "text" class = "form-control" id = "cita_date" uib-datepicker-popup ng-model = "vm.cita.date" is-open = "vm.date_control.opened" datepicker-options = "vm.date_control" ng-required = "true" close-text = "Cerrar" placeholder = "Seleccione una fecha" ng-change = "vm.GetCitasByDate()" />
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
                </div><!--/row-->

                <div class = "row justify-content-md-center">
                    <div class = "col-md-5 ">
                        <table class = "table">
                            <thead class="thead-dark">
                                <th></th>
                                <th>Selecciona un horario</th>
                                <th></th>
                            </thead>
                            <tbody ng-repeat = "cita in vm.cita.slots_list" ng-init = "cont = $index">
                                <tr ng-class = "($index % 2 === 0) ? 'table-active' : ''">
                                    <td><b>#@{{ $index+1 }}</b></td>
                                    <td><b>@{{ cita.init_slot }} - @{{ cita.final_slot }}</b></td>
                                    <td>
                                        <button ng-if = "cita.exist_cita == false && cita.selected == true" type = "button" class = "btn btn-success" ng-click = "vm.DeselectCita($index)"><i class = "fa fa-check"></i></button>
                                        <button ng-if = "cita.exist_cita == false && cita.selected == false" type = "button" class = "btn btn-secondary" ng-click = "vm.SelectCita($index)"><i class = "fa fa-check"></i></button> 
                                        <button ng-if = "cita.exist_cita == true" type = "button" class = "btn btn-danger"><i class = "fa fa-close"></i></button> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--/col-md-5-->
                </div><!--/row-->

                <button ng-if = "vm.cita.slots_list.length > 0" ng-disabled = "vm.cita.selected == null" type = "button" class = "btn btn-success" ng-click = "vm.SaveCita()">Agendar</button>

            </div><!--card-body-->
        </div><!--/card-->
    </div><!--/col-md-12-->
</div><!--/row-->
@stop