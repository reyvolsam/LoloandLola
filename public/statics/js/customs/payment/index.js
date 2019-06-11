angular.module('app', ['ng-currency', 'ui.bootstrap', 'angularFileUpload']).controller('appCtrl', ['$http', 'FileUploader', index_init]);

function index_init($http, FileUploader){
    var vm = this;
    
    $http.defaults.headers.post['X-CSRFToken'] = $('meta[name="csrf-token"]').attr('content');

    vm.delivery_date = '';

    vm.delivery_date_config = {
        dateDisabled: false,
        formatYear: 'yyyy',
        startingDay: 1,
        opened: false
    }

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

    vm.client_name = {}
    vm.client_name.disabled = true

    vm.client = {
        loader: false,
        list: {}
    }

    vm.payment_type_list = [
        {id: 1, name: 'Efectivo'},
        {id: 2, name: 'Transferencia'},
        {id: 3, name: 'Tarjeta de Débito/Crédito'},
        {id: 4, name: 'Otro'}
    ]

    vm.advance_payment_list = [
        {id: 1, name: 'Si'},
        {id: 2, name: 'No'},
    ]

    vm.payment = {
        fill_type: 1, //1 => Seleccionar cliente, 0 => Llenar manualmente
        loader: false,
        client: {
            id: null,
            name: '',
            email: '',
            phone: ''
        },
        service_loader: false,
        product_loader: false,
        type_id: null,
        discount_id: null,
        service_list: [],
        product_list: [],
        total_service: 0,
        total_product: 0,
        apply_advance_payment: 2,
        advance_payment: 0,
        delivery_date: '',
        subtotal: 0,
        grand_total: 0,
        payment_with: 0,
        exchange: 0
    }

    //USER
    vm.user = {}
    vm.label_module = 'Cliente'
    vm.profiles_list = [
        {id: 4, alias: 'Cliente'}
    ]

    vm.parameters_uploader = {
        url: 'payment2/upload_designs',
        removeAfterUpload: true,
        headers: {
            'X-CSRF-TOKEN': $http.defaults.headers.post['X-CSRFToken']
        },
        queueLimit: 1,
        filters: [{
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        }]
    };

    vm.uploader = new FileUploader(vm.parameters_uploader);

    vm.ResetUser = _ => 
    {
        vm.user.modal = {
            loader: false,
            title: 'Crear '+vm.label_module,
            phone: '',
            first_name: '',
            last_name: '',
            email: '',
            group_id: 4,
            active: true
        }
    }//ResetUser

    vm.SwitchClientFill = _ =>
    {
        vm.payment.fill_type = !vm.payment.fill_type

        if(vm.payment.fill_type == 1) vm.client_name.disabled = true
        if (vm.payment.fill_type == 0) vm.client_name.disabled = false

        vm.payment.client.id = null
        vm.payment.client.name = ''
        vm.payment.client.phone = ''
    }//vm.SwitchClientFill

    vm.OpenSelectClient = _ =>
    {
        $('#client_modal').modal('toggle')
        vm.client.loader = true
        $http.post('payment2/get_client')
        .success(res => {
            console.log(res)
            vm.client.loader = false
            if(res.status){
                vm.client.list = res.data
            } else {
                swal('¡Atención', res.msg, 'warning')
            }
        }).error(res => {
            vm.client.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.OpenSelectClient

    vm.SelectClient = ind =>
    {
        vm.payment.client.id = vm.client.list[ind].id
        vm.payment.client.name = vm.client.list[ind].first_name+' '+vm.client.list[ind].last_name
        vm.payment.client.email = vm.client.list[ind].email
        vm.payment.client.phone = vm.client.list[ind].phone
        vm.client.list = {}
        $('#client_modal').modal('toggle')
    }//vm.SelectClient

    vm.CancelSelectClient = _ =>
    {
        vm.client.list = {}
        $('#client_modal').modal('toggle')
    }//vm.CancelSelectClient

    vm.ApplyAdvancePayment = _ =>
    {
        if(vm.payment.apply_advance_payment == 2) vm.payment.advance_payment = 0.00
        vm.UpdateTotal()
    }//vm.ApplyAdvancePayment

    vm.OnFocusAdvancePayment = _ => document.getElementById("advance_payment").select();

    //// SERVICE
    vm.AddServiceModal = _ =>
    {
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

    vm.CancelSelectService = _ =>
    {
        vm.service_list = []
        $('#add_service_modal').modal('toggle')
    }//vm.CancelSelectService

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

        if(vm.payment.advance_payment == "" ) vm.payment.advance_payment = 0.00

        if(vm.payment.advance_payment > 0){
            vm.payment.grand_total = parseFloat(vm.payment.grand_total)-parseFloat(vm.payment.advance_payment)
        }

        vm.ChangePaymentWith()
    }//vm.UpdateServiceTotal

    vm.ChangeDiscount = _ => vm.UpdateTotal()
    vm.ChangeAdvancePayment = _ => vm.UpdateTotal()

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

        if(vm.payment.client.name.length == 0){
            vm.success_validation = false;
            (vm.payment.client.name.length == 0) ? msg = 'El nombre del cliente esta vacio.' : false;
        }

        if(vm.payment.service_list.length == 0 && vm.payment.product_list.length == 0){
            vm.success_validation = false
            msg = 'Seleccione un servicio o un producto.'
        }

        if(vm.payment.client.email.length > 0){
            if(!vm.ValidateEmail(vm.payment.client.email)){
                vm.success_validation = false
                msg = 'Correo electronico no valido.'
            }
        }

        // VALIDATION FILE
        if(vm.uploader.queue.length > 0){
            for(i in vm.uploader.queue){
                if(vm.uploader.queue[i]._file.size >= 7000000){
                    vm.success_validation = false
                    msg = 'El archivo solo puede pesar menos de 7 MB.';
                }
                let fileName = '';
                fileName = vm.uploader.queue[i]._file.name.split(".");
                if(fileName.length > 2){
                    vm.success_validation = false; 
                    msg = 'El nombre del archivo no puede contener puntos.'; 
                    vm.uploader.queue[i].remove();
                }
            }
        }

        if(vm.delivery_date != null){
            vm.payment.delivery_date = vm.delivery_date.getFullYear()+'-'+('0'+(vm.delivery_date.getMonth()+1)).slice(-2)+'-'+('0'+vm.delivery_date.getDate()).slice(-2)
        }

        if(vm.success_validation){
            vm.payment.loader = true
            $http.post('payment2/charge', vm.payment)
            .success(res => {
                console.log(res)
                if(res.status){
                    let status_response = 200
                    if(vm.uploader.queue.length > 0){
                        vm.uploader.onBeforeUploadItem = item => item.formData.push({payment_id: res.payment_id});
                        vm.uploader.onErrorItem = (status, response) =>{ console.log(response); status_response = status; }
                        vm.uploader.onCompleteAll = _ =>{
                            console.log('status_response', status_response)
                            if(status_response == 200){
                                swal('¡Éxito!', res.msg, 'success')
                                setTimeout(window.location = 'payment2/list', 7000)
                            } else {
                                swal('¡Éxito!', 'Error desconocido.', 'success')
                            }
                        }
                        vm.uploader.uploadAll();
                    } else {
                        swal('¡Éxito!', res.msg, 'success')
                        setTimeout(window.location = 'payment2/list', 7000)
                    }
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
        vm.payment = {
            fill_type: 1,
            loader: false,
            client: {
                id: null,
                name: '',
                email: ''
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
    }

    // USER

    vm.OpenModalUsers = _ =>
    {
        vm.ResetUser()
        $('#create_user_modal').modal('show')
    }//vm.OpenModalUsers

    vm.SaveUser = _ =>
    {
        vm.user.modal.loader = true

        if(vm.label_module == 'Cliente') vm.user.modal.group_id = 4

        $http.post('user', vm.user.modal)
        .success(res => {
            console.log(res)
            if(res.status){
                vm.ResetUser()
                swal('¡Éxito!', res.msg, 'success')
                $('#create_user_modal').modal('toggle')
                vm.SetClientPayment(res.client)
            } else {
                vm.user.modal.loader = false
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.user.modal.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        });
    }//vm.SaveUser

    vm.SetClientPayment = client =>
    {
        vm.payment.client.id = client.id
        vm.payment.client.name = client.first_name+' '+client.last_name
        vm.payment.client.email = client.email
        vm.payment.client.phone = client.phone
    }//vm.SetClientPayment

    vm.CancelUserModal = _ => 
    {
        vm.ResetUser()
        $('#create_user_modal').modal('toggle')
    }//vm.CancelUserModal


    vm.ValidateEmail = email =>
    {
        let regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) ? true : false;
    }
}//index_init