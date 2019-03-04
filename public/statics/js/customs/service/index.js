angular.module('app', ['ng-currency']).controller('appCtrl', ['$http', service_init]);

//https://github.com/aguirrel/ng-currency

function service_init($http){
    var vm = this

    vm.service = {}
    vm.service.list = {}
    vm.service.loader = false

    vm.ResetService = function () 
    {
        vm.service.modal = {
            loader: false,
            title: 'Crear Servicio',
            id: null,
            name: '',
            price: ''
        }
    }//ResetService

    vm.GetServicesList = () =>
    {
        vm.ResetService()

        vm.service.loader = true
        $http.post('service/list')
        .success(res => {
            console.log(res);
            vm.service.loader = false
            if(res.status){
                vm.service.list = res.data
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.service.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        });
    }//vm.GetUsersList()

    vm.OpenModalService = function()
    {
        $('#create_service_modal').modal('show')
    }//vm.OpenModalService

    vm.SaveService = function ()
    {
        console.log(vm.service.modal)
        vm.service.modal.loader = true
        console.log(vm.service.modal)
        $http.post('service', vm.service.modal)
        .success(res => {
            console.log(res)
            if(res.status){
                vm.ResetService()
                swal('¡Éxito!', res.msg, 'success')
                $('#create_service_modal').modal('toggle')
                vm.GetServicesList()
            } else {
                vm.service.modal.loader = false
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.service.modal.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        });
    }//vm.SaveUser

    vm.EditService = function (service)
    {
        vm.service.modal.title = 'Editar Servicio'
        vm.service.modal.id = service.id
        vm.service.modal.name = service.name
        vm.service.modal.price = service.price
        $('#create_service_modal').modal('show')
    }//vm.EditService

    vm.CancelServiceModal = function ()
    {
        vm.ResetService()
        $('#create_service_modal').modal('toggle')
    }//vm.CancelServiceModal


    vm.DeleteService = function (elem)
    {
        swal({
            title: "",
            text: "¿Desea eliminar este servicio?",
            type: "warning",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let id = elem.id
                vm.service.loader = true
                $http.delete('service/'+id)
                    .success(function (res){
                        console.log(res);
                        vm.service.loader = false
                        if(res.status){
                            vm.GetServicesList()
                            swal('¡Éxito!', res.msg, 'success')
                        } else {
                            swal('¡Atención!', res.msg, 'waning')
                        }
                    }).error(function (res){
                        console.log(res)
                        vm.service.loader = false
                        swal('¡Error!', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
                });
            }
        })
    }//vm.DeleteUsers

}//index_init