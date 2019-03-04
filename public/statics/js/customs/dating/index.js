angular.module('app', ['ui.bootstrap']).controller('appCtrl', ['$http', index_init]);

function index_init($http){
    var vm = this;

    vm.dip = '2013-01-18T12:00:00+00:00'

    vm.dating = {}
    vm.dating.init_slot = new Date()
    vm.dating.final_slot = new Date()

    vm.dating.config = {}
    vm.dating.config.hstep = 1
    vm.dating.config.mstep = 1
    vm.dating.config.ismeridian = true

    vm.dating.tabs = {
        day: 'monday',
        loader: false,
        monday: {
            loader: false,
            list: []
        },
        tuesday: {
            loader: false,
            list: []
        },
        wednesday: {
            loader: false,
            list: []
        },
        thursday: {
            loader: false,
            list: []
        },
        friday: {
            loader: false,
            list: []
        },
        saturday: {
            loader: false,
            list: []
        },
        sunday: {
            loader: false,
            list: []
        }
    };

    vm.dating.exceptions = {
        date: new Date(),
        list: {},
        list_loader: false,
        loader: false
    }

    vm.date_control = {
        dateDisabled: false,
        formatYear: 'yyyy',
        maxDate: new Date(2020, 5, 22),
        minDate: new Date(),
        startingDay: 1,
        opened: false
      };
    
    vm.InitLoad = () => 
    {
        vm.dating.tabs.loader = true
        $http.post('dating/get_schedules')
        .success(res => {
            console.log(res)
            if(res.status){
                vm.dating.tabs.monday.list = res.data.monday.list
                for(let i in vm.dating.tabs.monday.list){
                    vm.dating.tabs.monday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.monday.list[i].init_slot)
                    vm.dating.tabs.monday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.monday.list[i].final_slot)
                }
                vm.dating.tabs.tuesday.list = res.data.tuesday.list
                for(let i in vm.dating.tabs.tuesday.list){
                    vm.dating.tabs.tuesday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.tuesday.list[i].init_slot)
                    vm.dating.tabs.tuesday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.tuesday.list[i].final_slot)
                }
                vm.dating.tabs.wednesday.list = res.data.wednesday.list
                for(let i in vm.dating.tabs.wednesday.list){
                    vm.dating.tabs.wednesday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.wednesday.list[i].init_slot)
                    vm.dating.tabs.wednesday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.wednesday.list[i].final_slot)
                }
                vm.dating.tabs.thursday.list = res.data.thursday.list
                for(let i in vm.dating.tabs.thursday.list){
                    vm.dating.tabs.thursday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.thursday.list[i].init_slot)
                    vm.dating.tabs.thursday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.thursday.list[i].final_slot)
                }
                vm.dating.tabs.friday.list = res.data.friday.list
                for(let i in vm.dating.tabs.friday.list){
                    vm.dating.tabs.friday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.friday.list[i].init_slot)
                    vm.dating.tabs.friday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.friday.list[i].final_slot)
                }
                vm.dating.tabs.saturday.list = res.data.saturday.list
                for(let i in vm.dating.tabs.saturday.list){
                    vm.dating.tabs.saturday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.saturday.list[i].init_slot)
                    vm.dating.tabs.saturday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.saturday.list[i].final_slot)
                }
                vm.dating.tabs.sunday.list = res.data.sunday.list
                for(let i in vm.dating.tabs.sunday.list){
                    vm.dating.tabs.sunday.list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs.sunday.list[i].init_slot)
                    vm.dating.tabs.sunday.list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs.sunday.list[i].final_slot)
                }

                vm.dating.exceptions.list = res.exception_date_list
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
            vm.dating.tabs.loader = false
        }).error(res => {
            console.log(res)
            vm.dating.tabs.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.InitLoad


    vm.AddSchedule = () =>
    {
        let init_slot = null;
        let final_slot = null;

        init_slot = vm.dating.init_slot.getHours()+':'+vm.dating.init_slot.getMinutes()
        final_slot = vm.dating.final_slot.getHours()+':'+vm.dating.final_slot.getMinutes()

        vm.dating.tabs[vm.dating.tabs.day].loader = true
        $http.post('dating', 
        {
            init_slot: init_slot, 
            final_slot: final_slot,
            day: vm.dating.tabs.day
        }).success(res => {
            console.log(res)
            vm.dating.tabs[vm.dating.tabs.day].loader = false
            if(res.status){
                vm.dating.tabs[vm.dating.tabs.day].list = res.data
                for(let i in vm.dating.tabs[vm.dating.tabs.day].list){
                    vm.dating.tabs[vm.dating.tabs.day].list[i].init_slot = vm.ConvertTo12H(vm.dating.tabs[vm.dating.tabs.day].list[i].init_slot)
                    vm.dating.tabs[vm.dating.tabs.day].list[i].final_slot = vm.ConvertTo12H(vm.dating.tabs[vm.dating.tabs.day].list[i].final_slot)
                }
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res)
            vm.dating.tabs[vm.dating.tabs.day].loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.AddSchedule

    vm.DeleteSlot = slot_id =>
    {
        swal({
            title: "",
            text: "¿Desea eliminar este slot?",
            type: "warning",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                vm.dating.tabs[vm.dating.tabs.day].loader = true
                $http.post('dating/delete_slot', {slot_id: slot_id, day: vm.dating.tabs.day})
                .success(res=> {
                    console.log(res)
                    vm.dating.tabs[vm.dating.tabs.day].loader = false
                    vm.dating.tabs[vm.dating.tabs.day].list = res.slots
                    if(res.status){
                        swal('¡Éxito!', res.msg, 'success')
                    } else {
                        swal('¡Atención!', res.msg, 'warning')
                    }
                }).error(res=> {
                    console.log(res)
                    vm.dating.tabs[vm.dating.tabs.day].loader = false
                    swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
                })
            }
        })
    }//vm.DeleteSlot

    vm.AddDate = _ =>
    {
        let final_date = null

        let dd = new Date(vm.dating.exceptions.date)

        final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)

        vm.dating.exceptions.loader = true

        $http.post('dating/add_exception', {date: final_date})
        .success(res => {
            console.log(res);
            vm.dating.exceptions.loader = false
            if(res.status){
                vm.dating.exceptions.list = res.date_list
                swal('Éxito!', res.msg, 'success')
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res => {
            console.log(res);
            vm.dating.exceptions.loader = false
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//vm.AddDate

    vm.DeleteExceptionDate = id => 
    {
        swal({
            title: "",
            text: "¿Desea eliminar esta fecha?",
            type: "warning",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                vm.dating.exceptions.list_loader = true
                vm.dating.exceptions.list = {};
                $http.post('dating/delete_exception_date', {id: id})
                .success(res=>{
                    console.log(res)
                    vm.dating.exceptions.list = res.date_list
                    vm.dating.exceptions.list_loader = false
                    if(res.status){
                        swal('¡Éxito!', res.msg, 'success')
                    } else {
                        swal('¡Atención!', res.msg, 'warning')
                    }
                }).error(res=>{
                    console.log(res)
                    vm.dating.exceptions.list_loader = false
                    swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
                });
            }
        });
    }//vm.DeleteExceptionDate

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