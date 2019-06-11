angular.module('app', []).controller('appCtrl', ['$http', user_init]);

function user_init($http){
    var vm = this

    vm.label_module = label_module

    vm.user = {}
    vm.user.list = {}
    vm.user.loader = false

    vm.user.password_modal = {
        id: null,
        password: '',
        password_confirm: '',
        loader: false
    }

    vm.profiles_list = [
        {id: 1, alias: 'root'}, 
        {id: 2, alias: 'Administrador'}, 
        {id: 3, alias: 'Empleado'}, 
        {id: 4, alias: 'Cliente'}
    ]

    vm.ResetUser = function () 
    {
        vm.user.modal = {
            loader: false,
            title: 'Crear '+vm.label_module,
            phone: '',
            first_name: '',
            last_name: '',
            email: '',
            group_id: null,
            active: true
        }
    }//ResetUser

    vm.GetUsersList = _ =>
    {
        vm.ResetUser()

        vm.user.loader = true
        $http.post('user/list')
        .success(res => {
            console.log(res);
            vm.user.loader = false
            if(res.status){
                vm.user.list = res.data
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.user.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        });
    }//vm.GetUsersList()

    vm.OpenModalUsers = _ =>
    {
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
                vm.GetUsersList()
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

    vm.EditUser =  user =>
    {
        vm.user.modal.title = 'Editar Usuario'
        vm.user.modal.id = user.id
        vm.user.modal.first_name = user.first_name
        vm.user.modal.last_name = user.last_name
        vm.user.modal.email = user.email
        vm.user.modal.phone = user.phone
        vm.user.modal.group_id = user.group.id
        vm.user.modal.active = (user.active) ? true : false
        $('#create_user_modal').modal('show')
    }//vm.EditUser

    vm.CancelUserModal = _ => 
    {
        vm.ResetUser()
        $('#create_user_modal').modal('toggle')
    }//vm.CancelUserModal

    vm.DeleteUser = elem => 
    {
        swal({
            title: "",
            text: "¿Desea eliminar este usuario?",
            type: "warning",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let id = elem.id
                vm.user.loader = true
                $http.delete('user/'+id)
                    .success(function (res){
                        console.log(res);
                        vm.user.loader = false
                        if(res.status){
                            vm.GetUsersList()
                            swal('¡Éxito!', res.msg, 'success')
                        } else {
                            swal('¡Atención!', res.msg, 'waning')
                        }
                    }).error(function (res){
                        console.log(res)
                        vm.user.loader = false
                        swal('¡Error!', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
                });
            }
        })
    }//vm.DeleteUsers

    vm.OpenUpdatePasswordModal = user =>
    {
        vm.user.password_modal.id = user.id
        $('#update_password_modal').modal('toggle')
        console.log('user', user)
    }//vm.UpdatePassword

    vm.UpdateUserPassword = _ =>
    {
        vm.user.password_modal.loader = true
        console.log('vm.user.password_modal', vm.user.password_modal)
        $http.post('user/reset_password', vm.user.password_modal)
        .success(res =>{
            console.log(res)
            vm.user.password_modal.loader = false
            if(res.status){
                vm.user.password_modal = {
                    id: null,
                    password: '',
                    password_confirm: '',
                    loader: false
                }
                $('#update_password_modal').modal('toggle')
                swal('¡Éxito!', res.msg, 'success')
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            vm.user.password_modal.loader = false
            console.log(res)
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')

        })
    }//vm.UpdateUserPassword

    vm.CancelPasswordModal = _ =>
    {
        vm.user.password_modal = {
            id: null,
            password: '',
            password_confirm: '',
            loader: false
        }
        $('#update_password_modal').modal('toggle')
    }//vm.CancelPasswordModal
}//index_init