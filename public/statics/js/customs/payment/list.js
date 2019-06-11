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

    vm.delivery_date = ''
    vm.service_list = {}
    vm.product_list = {}

    vm.date_init = null
    vm.date_final = null
    
    vm.date_control = {
        dateDisabled: false,
        formatYear: 'yyyy',
        startingDay: 1,
        opened: false
    }

    vm.control_init = {
        dateDisabled: false,
        formatYear: 'yyyy',
        startingDay: 1,
        opened: false
    }

    vm.control_final = {
        dateDisabled: false,
        formatYear: 'yyyy',
        startingDay: 1,
        opened: false
    }

    vm.design_image = '#'

    vm.GetPayments = _ =>
    {
        vm.list.loader = true
        let final_date_init = null
        let final_date_final = null

        if(vm.date_init != null && vm.date_final != null){
            let dd1 = vm.date_init
            let dd2 = vm.date_final
            final_date_init = dd1.getFullYear()+'-'+('0'+(dd1.getMonth()+1)).slice(-2)+'-'+('0'+dd1.getDate()).slice(-2)
            final_date_final = dd2.getFullYear()+'-'+('0'+(dd2.getMonth()+1)).slice(-2)+'-'+('0'+dd2.getDate()).slice(-2)
        }
        vm.list.list = {}
        $http.post('get_payment_list', 
        {
            page: vm.list.page, 
            date_init: final_date_init, 
            date_final: final_date_final
        }).success(res =>{
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
        vm.delivery_date = vm.list.list[ind].delivery_date 
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
    
    vm.OpenDesignImageModal = ind =>
    {
        console.log('vm.list.list', vm.list.list[ind])
        vm.design_image = vm.list.list[ind].design_image
        $('#payment_image_modal').modal('toggle')
    }//vm.OpenDesignImageModal

    vm.CloseDesignImage = _ =>
    {
        $('#payment_image_modal').modal('toggle')
    }//vm.CloseDesignImage

}////