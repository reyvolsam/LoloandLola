angular.module('app', ['ng-currency']).controller('appCtrl', ['$http', service_init]);

//https://github.com/aguirrel/ng-currency

function service_init($http){
    var vm = this

    vm.product = {}
    vm.product.list = {}
    vm.product.loader = false

    vm.ResetProduct = function () 
    {
        vm.product.modal = {
            loader: false,
            title: 'Crear Servicio',
            id: null,
            name: '',
            price: '',
            stock: 0
        }
    }//ResetService

    vm.GetProductList = () =>
    {
        vm.ResetProduct()

        vm.product.loader = true
        vm.product.list = {}
        $http.post('product/list')
        .success(res => {
            console.log(res);
            vm.product.loader = false
            if(res.status){
                vm.product.list = res.data
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.product.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        });
    }//vm.GetUsersList()

    vm.OpenModalProduct = function()
    {
        $('#create_product_modal').modal('show')
    }//vm.OpenModalService

    vm.SaveProduct = function ()
    {
        console.log(vm.product.modal)
        vm.product.modal.loader = true
        console.log(vm.product.modal)
        $http.post('product', vm.product.modal)
        .success(res => {
            console.log(res)
            if(res.status){
                vm.ResetProduct()
                swal('¡Éxito!', res.msg, 'success')
                $('#create_product_modal').modal('toggle')
                vm.GetProductList()
            } else {
                vm.product.modal.loader = false
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.product.modal.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        });
    }//vm.SaveUser

    vm.EditProduct = function (product)
    {
        vm.product.modal.title = 'Editar Producto'
        vm.product.modal.id = product.id
        vm.product.modal.name = product.name
        vm.product.modal.price = product.price;
        (product.stock == null) ? product.stock = 0 : vm.product.modal.stock = product.stock
        $('#create_product_modal').modal('show')
    }//vm.EditService

    vm.ChangeStock = _ =>
    {
        if(vm.product.modal.stock == null || vm.product.modal.stock < 0){
            vm.product.modal.stock = 0
        }
    }//vm.ChangeStock

    vm.CancelProductModal = function ()
    {
        vm.ResetProduct()
        $('#create_product_modal').modal('toggle')
    }//vm.CancelServiceModal


    vm.DeleteProduct = function (elem)
    {
        swal({
            title: "",
            text: "¿Desea eliminar este producto?",
            type: "warning",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let id = elem.id
                vm.product.loader = true
                $http.delete('product/'+id)
                    .success(function (res){
                        console.log(res);
                        vm.product.loader = false
                        if(res.status){
                            vm.GetProductList()
                            swal('¡Éxito!', res.msg, 'success')
                        } else {
                            swal('¡Atención!', res.msg, 'waning')
                        }
                    }).error(function (res){
                        console.log(res)
                        vm.product.loader = false
                        swal('¡Error!', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
                });
            }
        })
    }//vm.DeleteUsers

}//index_init