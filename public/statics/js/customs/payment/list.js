angular.module('app', ['ng-currency', 'ui.bootstrap']).controller('appCtrl', ['$http', index_init]);

function index_init($http){
    var vm = this;

    $http.defaults.headers.post['X-CSRFToken'] = $('meta[name="csrf-token"]').attr('content');

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

    vm.payment_admin = {
        payment_id: null,
        payments_list: new Array(),
        quantity: 0,
        full_payment: 0, 
        advance_payment: 0,
        grand_total: 0,
        subtract: 0,
        loader: false,
        finalized_ticket: false,
        loader_finelize: false
    }

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
        vm.design_image = vm.list.list[ind].design_image
        $('#payment_image_modal').modal('toggle')
    }//vm.OpenDesignImageModal

    vm.CloseDesignImage = _ =>
    {
        $('#payment_image_modal').modal('toggle')
    }//vm.CloseDesignImage

    vm.OpenApplyAdvancePayment = ind =>
    {
        $('#advance_payment_modal').modal('toggle')
        vm.payment_admin.payment_id = vm.list.list[ind].id
        vm.payment_admin.payments_list = vm.list.list[ind].payments_list
        vm.payment_admin.advance_payment = vm.list.list[ind].advance_payment
        vm.payment_admin.grand_total = vm.list.list[ind].grand_total
        vm.payment_admin.finalized_ticket = vm.list.list[ind].finalized_ticket

        if(vm.payment_admin.finalized_ticket == true){
            vm.payment_admin.loader = true
        }

        vm.SUMPaymentsList(vm.payment_admin.payments_list)
    }//vm.OpenApplyAdvancePayment

    vm.FinelizeTicket = _ => 
    {
        vm.payment_admin.loader_finelize = true
        vm.payment_admin.loader = true
        $http.post('payment/finelize', {payment_id: vm.payment_admin.payment_id})
        .success(res => {
            console.log(res)
            vm.payment_admin.loader = false
            vm.payment_admin.loader_finelize = false
            if(res.status){
                vm.payment_admin.finalized_ticket = res.data

                if(vm.payment_admin.finalized_ticket == true){
                    vm.payment_admin.loader = true
                }
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.payment_admin.loader = false
            vm.payment_admin.loader_finelize = false
        })
    }//vm.FinelizedTicket

        vm.AddQuantityPayment = _ =>
        {
            if(vm.CheckQuantity()){
                vm.payment_admin.loader = true
                $http.post('payment/add', 
                {
                    quantity: vm.payment_admin.quantity, 
                    payment_id: vm.payment_admin.payment_id
                })
                .success(res => {
                    vm.payment_admin.loader = false
                    if(res.status){
                        vm.payment_admin.quantity = 0
                        vm.payment_admin.payments_list = res.data
                        vm.SUMPaymentsList(vm.payment_admin.payments_list)
                        vm.FinalizedTicket()
                    } else {
                        swal('¡Atención!', res.msg, 'warning')
                    }
                }).error(res => {
                    vm.payment_admin.loader = false
                })
            }
        }//vm.AddPayment   

            vm.FinalizedTicket = _ =>
            {
                let result = false

                if(vm.payment_admin.subtract == 0){
                    vm.payment_admin.loader = true
                    $http.post('payment/finalizedCheck', {payment_id: vm.payment_admin.payment_id})
                    .success(res => {
                        console.log(res);
                        vm.payment_admin.loader = false
                        if(res.status){
                            vm.payment_admin.finalized_ticket = res.data
                        } else {
                            swal('¡Atención!', res.msg, 'warning')
                        }
                    }).error(res =>{
                        console.log(res)
                        vm.payment_admin.loader = false
                    })
                } else {
                    vm.payment_admin.finalized_ticket = false
                }
                return result
            }//vm.FinalizeTicket

        vm.DeletePayment = ind =>
        {
            console.log('list', vm.payment_admin.payments_list[ind])
            vm.payment_admin.payments_list.splice(ind, 1)
            vm.payment_admin.loader = true
            $http.post('payment/delete', 
            {
                payment_id: vm.payment_admin.payment_id,
                payments_list: vm.payment_admin.payments_list
            }).success(res => {
                console.log(res)
                vm.payment_admin.loader = false
                if(res.status){
                    vm.payment_admin.payments_list = res.data
                    vm.SUMPaymentsList(vm.payment_admin.payments_list)
                } else {
                    swal('¡Atención!', res.msg, 'warning')
                }
            }).error(res => {
                vm.payment_admin.loader = false
                console.log(res)
            })
            vm.SUMPaymentsList(vm.payment_admin.payments_list)
        }//vm.DeletePayment

        vm.CheckQuantity = _ =>
        {
            if(vm.payment_admin.quantity > vm.payment_admin.subtract){
                swal('¡Atención!', 'La cantidad a abonar es mayor a la cantidad restante', 'warning')
                return false
            } else {
                return true
            }
        }//vm.CheckQuantity

        vm.SUMPaymentsList = payments_list =>
        {
            if(payments_list.length > 0){
                vm.payment_admin.full_payment = 0
                for(i in payments_list){
                    vm.payment_admin.full_payment = (parseFloat(payments_list[i].quantity) + parseFloat(vm.payment_admin.full_payment)).toFixed(2)
                }
            } else {
                vm.payment_admin.full_payment = 0;
            }
            vm.CalculateSubtract()
        }//vm.SUMPaymentsList

        vm.CalculateSubtract = _ =>
        {
            let r = parseFloat(vm.payment_admin.full_payment) + parseFloat(vm.payment_admin.advance_payment)

            vm.payment_admin.subtract = (parseFloat(vm.payment_admin.grand_total) - r).toFixed(2);

        }//vm.CalculateSubtract

    vm.CloseAdvancePayment = _ => 
    {
        $('#advance_payment_modal').modal('toggle')
    } 

}////