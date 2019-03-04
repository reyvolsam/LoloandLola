angular.module('app', ['ui.bootstrap']).controller('appCtrl', ['$http', index_init]);

function index_init($http){
    var vm = this;

    vm.list = {
        loader: false,
        list: {},
        total_payment: 0.00,
        page: 1,
        total_pages: 1,
        paginator_list: []
    }

    vm.service_list = {}
    vm.product_list = {}

    vm.cita = {}
    vm.cita.date = null
    
    vm.date_control = {
        dateDisabled: false,
        formatYear: 'yyyy',
        startingDay: 1,
        opened: false
    }

    sessionStorage.removeItem("user_slot_id")

    vm.GetPayments = _ =>
    {
        vm.list.loader = true
        let final_date = null
        if(vm.cita.date != null){
            let dd = vm.cita.date
            final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)
        }
        vm.list.list = {}
        console.log('vm.list.page', vm.list.page)
        $http.post('get_payment_list', {page: vm.list.page, date: final_date})
        .success(res =>{
            console.log(res)
            vm.list.loader = false
            if(res.status){
                vm.list.list = res.data
                vm.list.total_payment = res.grand_total_payment
                vm.list.total_pages = res.total_pages
                vm.BuildPaginatorArray()
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.list.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.GetPayments

    vm.OpenServiceModal = ind =>
    {
        vm.service_list = {}
        vm.product_list = {}
        $('#service_list_modal').modal('toggle')
        vm.service_list = vm.list.list[ind].service_payment
        vm.product_list = vm.list.list[ind].product_payment
    }//vm.OpenServiceModal

    vm.BuildPaginatorArray = _ =>
    {
        vm.list.paginator_list = []
        let i = 0

        for (i; i < vm.list.total_pages; i++){
            let ind = i+1

            let aux = {
                number: ind, 
                style:{
                    'page-item': true,
                    active: (ind==vm.list.page) ? true : false
                }
            }
            vm.list.paginator_list.push(aux)
        }
        console.log('vm.list.paginator_list', vm.list.paginator_list)
    }//vm.BuildPaginatorArray
    
}////