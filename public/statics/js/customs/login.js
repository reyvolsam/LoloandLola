angular.module('app', []).controller('appCtrl', ['$http', login_init]);

function login_init($http){
    var vm = this;

    $http.defaults.headers.post['X-CSRFToken'] = $('meta[name="csrf-token"]').attr('content');

    vm.login_data = {};
    vm.loader = false;

    vm.SubmitLogin = function(){
        vm.loader = true;
        $http.post("login", vm.login_data)
            .success(function(res){
                console.log(res);
                if(res.status){
                    if(res.profile_id == 3){
                        window.location = 'payment2';
                    } else {
                        window.location = 'index';
                    }
                    
                } else {
                    vm.loader = false;
                    swal("¡Atención!", res.msg, "warning");
                }
            }).error(function (res){
                console.log(res);
                vm.loader = true;
                swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error');
        });
    }//end SubmitRegister
}//end register_init