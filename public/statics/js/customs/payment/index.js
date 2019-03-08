angular.module('app', ['ng-currency', 'ui.bootstrap']).controller('appCtrl', ['$http', index_init]);

function index_init($http){
    var vm = this;

    vm.service_list = {}
    vm.discount_list = [
        {id: 1, name: '5%', discount: 5},
        {id: 2, name: '10%', discount: 10},
        {id: 3, name: '15%', discount: 15},
        {id: 4, name: '20%', discount: 20},
        {id: 5, name: '25%', discount: 25},
        {id: 6, name: '30%', discount: 30},
        {id: 7, name: '35%', discount: 35},
        {id: 8, name: '40%', discount: 40},
        {id: 9, name: '50%', discount: 50},
        {id: 10, name: '60%', discount: 60},
        {id: 11, name: '80%', discount: 80},
        {id: 12, name: '90%', discount: 90},
        {id: 13, name: '100%', discount: 100}
    ]

    vm.payment_type_list = [
        {id: 1, name: 'Efectivo'},
        {id: 2, name: 'Transferencia'},
        {id: 3, name: 'Tarjeta de Débito/Crédito'},
        {id: 4, name: 'Otro'}
    ]

    vm.date_control = {
        dateDisabled: false,
        formatYear: 'yyyy',
        maxDate: new Date(2020, 5, 22),
        startingDay: 1,
        opened: false
    }

    vm.cita = {}
    vm.cita.loader = false
    vm.cita.date = null
    vm.cita.slots_list = []
    vm.cita.selected = null

    vm.payment = {
        fill_type: 1, //1 => Seleccionar cliente, 0 => Llenar manualmente
        loader: false,
        user_slot_id: sessionStorage.getItem("user_slot_id"),
        client: {
            name: '',
            phone: '',
            init_slot: '',
            final_slot: '',
            date: '',
            schedule: ''
        },
        service_loader: false,
        product_loader: false,
        type_id: null,
        discount_id: null,
        service_list: [],
        product_list: [],
        total_service: 0,
        total_product: 0,
        subtotal: 0,
        grand_total: 0,
        payment_with: 0,
        exchange: 0
    }

    vm.cita_date = { disabled: false }

    vm.client_name = { disabled: true }
    vm.client_date = { disabled: true }
    vm.client_schedule = { disabled: true }

    vm.Inint = _ =>
    {
        if(vm.payment.user_slot_id != null){
            $http.post('payment2/get_client', {user_slot_id: vm.payment.user_slot_id})
            .success(res => {
                console.log(res)
                if(res.status){
                    vm.payment.client.name = res.data.name 
                    vm.payment.client.phone = res.data.phone
                    vm.payment.client.init_slot = res.data.init_slot
                    vm.payment.client.final_slot = res.data.final_slot
                    vm.payment.client.date = res.data.date
                    vm.payment.client.schedule = res.data.init_slot+' - '+res.data.final_slot
                } else {
                    swal('¡Atención!', res.msg, 'warning')
                }
            }).error(res => {
                console.log(res)
                swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
            })
        } else {
            console.log('nada')
        }
    }//vm.Inint

    vm.SwitchClientFill = _ =>
    {
        vm.payment.fill_type = !vm.payment.fill_type

        if(vm.payment.fill_type == 1){
            vm.cita_date.disabled = false

            vm.client_name.disabled = true
            vm.client_date.disabled = true
            vm.client_schedule.disabled = true
            
        } 
        if (vm.payment.fill_type == 0) {
            vm.cita_date.disabled = true

            vm.client_name.disabled = false
            vm.client_date.disabled = false
            vm.client_schedule.disabled = false
        }

        vm.payment.user_slot_id = null
        vm.payment.client.name = ''
        vm.payment.client.phone = ''
        vm.payment.client.init_slot = ''
        vm.payment.client.final_slot = ''
        vm.payment.client.date = ''
        vm.payment.client.schedule = ''
    }//vm.SwitchClientFill

    vm.GetCitasByDate = _ => 
    {
        $('#slot_citas_modal').modal('toggle')
        vm.cita.loader = true
        let dd = vm.cita.date        
        let d = new Date(dd.getFullYear(), dd.getMonth(), dd.getDate())
        let final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)
        $http.post('citas/get_citas', { day: d.getDay(), date: final_date })
        .success(res =>{
            console.log(res)
            if(res.status){
                vm.cita.loader = false
                vm.cita.slots_list = res.data
                for(let i in vm.cita.slots_list){
                    vm.cita.slots_list[i].init_slot = vm.ConvertTo12H(vm.cita.slots_list[i].init_slot)
                    vm.cita.slots_list[i].final_slot = vm.ConvertTo12H(vm.cita.slots_list[i].final_slot)
                }
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res=>{
            console.log(res)
            vm.cita.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//

    vm.SelectClient = ind =>
    {
        console.log(vm.cita.slots_list[ind])
        vm.payment.user_slot_id = vm.cita.slots_list[ind].user_slot_id 
        vm.payment.client.name = vm.cita.slots_list[ind].client_name 
        vm.payment.client.phone = vm.cita.slots_list[ind].phone
        vm.payment.client.init_slot = vm.cita.slots_list[ind].init_slot
        vm.payment.client.final_slot = vm.cita.slots_list[ind].final_slot
        vm.payment.client.date = vm.cita.slots_list[ind].date
        vm.payment.client.schedule = vm.cita.slots_list[ind].init_slot+' - '+vm.cita.slots_list[ind].final_slot
        $('#slot_citas_modal').modal('toggle')
        vm.cita.date = null
        vm.cita.slots_list = {}
    }//vm.SelectClient

    vm.CancelSelectClient = _ =>
    {
        vm.cita.slots_list = {}
        vm.cita.date = null
        $('#slot_citas_modal').modal('toggle')
    }//vm.CancelSelectClient

    //// SERVICE
    vm.AddServiceModal = _ =>
    {
        console.log('vm.payment.type_id', vm.payment.type_id)
        $('#add_service_modal').modal('toggle')
        vm.payment.service_loader = true
        $http.post('service/list')
        .success(res => {
            console.log(res)
            vm.payment.service_loader = false
            if(res.status){
                vm.service_list = res.data
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.payment.service_loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.AddService

    vm.AddServiceToPayment = ind =>
    {
        vm.payment.service_list.push(vm.service_list[ind])
        $('#add_service_modal').modal('toggle')
        vm.UpdateTotal()
        vm.service_list = {}
    }//vm.AddServiceToPayment

    vm.RemoveServiceFromPayment = ind =>
    {
        vm.payment.service_list.splice(ind, 1)
        vm.UpdateTotal()
    }//vm.RemoveServiceFromPayment()

    vm.ChangeQuantityService = ind =>
    {
        if(vm.payment.service_list[ind].quantity < 0) vm.payment.service_list[ind].quantity = 1;

        vm.UpdateTotal()
    }//vm.ChangeQuantityService

    //// PRODUCT
    vm.AddProductModal = _ =>
    {
        $('#add_product_modal').modal('toggle')
        vm.payment.product_loader = true
        $http.post('product/list')
        .success(res => {
            console.log(res)
            vm.payment.product_loader = false
            if(res.status){
                vm.product_list = res.data
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.payment.product_loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.AddProduct

    vm.AddProductToPayment = ind =>
    {
        vm.payment.product_loader = true
        $http.post('product/check_stock', {product_id: vm.product_list[ind].id, quantity: 1})
        .success(res =>{
            console.log(res)
            vm.payment.product_loader = false
            if(res.status){
                vm.payment.product_list.push(vm.product_list[ind])
                $('#add_product_modal').modal('toggle')
                vm.UpdateTotal()
                vm.product_list = {}
            } else {
                swal('¡Atención', res.msg, 'warning')
            }
        }).error(res =>{
            console.log(res)
            vm.payment.product_loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.AddServiceToPayment

    vm.CancelSelectProduct = _ =>
    {
        vm.product_list = {}
        $('#add_product_modal').modal('toggle')
    }//vm.CancelSelectProduct

    vm.RemoveProductFromPayment = ind =>
    {
        vm.payment.product_list.splice(ind, 1)
        vm.UpdateTotal()
    }//vm.RemoveProductFromPayment()

    vm.ChangeQuantityProduct = ind =>
    {

        if(vm.payment.product_list[ind].quantity < 0) vm.payment.product_list[ind].quantity = 1;

        vm.payment.loader = true
        $http.post('product/check_stock', { product_id: vm.payment.product_list[ind].id, quantity: vm.payment.product_list[ind].quantity })
        .success(res =>{
            console.log(res)
            vm.payment.loader = false
            if(res.status){
            } else {
                vm.payment.product_list[ind].quantity = 1
                swal('¡Atención', res.msg, 'warning')
            }
            vm.UpdateTotal()
        }).error(res =>{
            console.log(res)
            vm.payment.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })

    }//vm.ChangeQuantityProduct


    vm.UpdateTotal = _ =>
    {
        vm.payment.total_service = 0
        vm.payment.total_product = 0
        vm.payment.subtotal = 0
        vm.payment.grand_total = 0

        if(vm.payment.service_list.length > 0){
            vm.payment.service_list.forEach((e,i) =>{
                e.total = parseInt(e.quantity)*parseFloat(e.price)
                e.total = e.total.toFixed(2)

                vm.payment.total_service = parseFloat(vm.payment.total_service)+parseFloat(e.total)
                vm.payment.total_service = vm.payment.total_service.toFixed(2)
            })
        }

        if(vm.payment.product_list.length > 0){
            vm.payment.product_list.forEach((e,i) =>{
                e.total = parseInt(e.quantity)*parseFloat(e.price)
                e.total = e.total.toFixed(2)

                vm.payment.total_product = parseFloat(vm.payment.total_product)+parseFloat(e.total)
                vm.payment.total_product.toFixed(2)
            })
        }

        vm.payment.subtotal = parseFloat(vm.payment.total_service)+parseFloat(vm.payment.total_product)

        if(vm.payment.discount_id != null){
            let discount_percent = null
            discount_percent = vm.discount_list.filter((e)=>e.id === vm.payment.discount_id);
            let discount = 0;
            discount = (parseFloat(vm.payment.subtotal)*parseInt(discount_percent[0].discount))/100
            vm.payment.grand_total = parseFloat(vm.payment.subtotal)-parseFloat(discount)
        } else {
            vm.payment.grand_total = parseFloat(vm.payment.subtotal)
        }

        vm.ChangePaymentWith()
    }//vm.UpdateServiceTotal

    vm.ChangeDiscount = _ => vm.UpdateTotal()

    vm.ChangePaymentWith = _ => 
    {
        if(vm.payment.payment_with > vm.payment.grand_total){
            vm.payment.exchange = parseFloat(vm.payment.grand_total)-parseFloat(vm.payment.payment_with)
            vm.payment.exchange = vm.payment.exchange.toFixed(2)
        } else {
            vm.payment.exchange = 0
        }
    }//vm.ChangePaymentWith

    vm.MakeCharge = _ =>
    {
        vm.payment.loader = true
         let msg = '';

        vm.success_validation = true // Validation success

        if(vm.payment.client.name.length == 0 || vm.payment.client.date.length == 0){
            vm.success_validation = false;
            (vm.payment.client.name.length == 0) ? msg = 'El nombre del cliente esta vacio.' : false;
            (vm.payment.client.date.length == 0) ? msg = 'La fecha de la cita esta vacia.' : false;
        }

        if(vm.payment.service_list.length == 0 && vm.payment.product_list.length == 0){
            vm.success_validation = false
            msg = 'Seleccione un servicio o un producto.'
        }

        if(vm.success_validation){
            console.log(vm.payment)
            $http.post('payment2/charge', vm.payment)
            .success(res => {
                console.log(res)
                if(res.status){
                    sessionStorage.removeItem("user_slot_id")
                    swal('¡Éxito!', res.msg, 'success')
                    setTimeout(window.location = 'payment2/list', 5000)
                } else {
                    vm.payment.loader = false
                    swal('¡Atención!', res.msg, 'warning')
                }
            }).error(res => {
                console.log(res)
                vm.payment.loader = false
                swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
            })
        } else {
            swal('¡Atención!', msg, 'warning')
        }
    }//vm.MakeCharge

    vm.CancelPayment = _ =>
    {
        vm.cita = {}
        vm.cita.loader = false
        vm.cita.date = null
        vm.cita.slots_list = []
        vm.cita.selected = null
    
        vm.payment = {
            fill_type: 1,
            loader: false,
            user_slot_id: sessionStorage.getItem("user_slot_id"),
            client: {
                name: '',
                phone: '',
                init_slot: '',
                final_slot: '',
                date: '',
                schedule: ''
            },
            service_loader: false,
            product_loader: false,
            type_id: null,
            discount_id: null,
            service_list: [],
            product_list: [],
            total_service: 0,
            total_product: 0,
            subtotal: 0,
            grand_total: 0,
            payment_with: 0,
            exchange: 0
        }
    
        vm.cita_date = { disabled: false }
    
        vm.client_name = { disabled: true }
        vm.client_date = { disabled: true }
        vm.client_schedule = { disabled: true }
    }

    vm.ConvertTo12H = v =>
    {
        let t = v.split(':')

        time = ('0'+t[0]).slice(-2)+':'+('0'+t[1]).slice(-2)

        time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
      
        if (time.length > 1) {
          time = time.slice (1)
          time[5] = +time[0] < 12 ? 'AM' : 'PM'
          time[0] = +time[0] % 12 || 12
        }
        return time.join ('')
    }//
}//index_init