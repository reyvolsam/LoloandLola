angular.module('app', ['ui.bootstrap']).controller('appCtrl', ['$http', index_init]);

function index_init($http){
    var vm = this

    vm.cita = {}

    vm.date_control = {
        dateDisabled: false,
        formatYear: 'yyyy',
        maxDate: new Date(2020, 5, 22),
        minDate: new Date(),
        startingDay: 1,
        opened: false
    }

    vm.cita.date = null
    vm.cita.slots_list = []
    vm.cita.selected = null

    vm.GetCitasByDate = _ => 
    {
        let dd = vm.cita.date        
        let d = new Date(dd.getFullYear(), dd.getMonth(), dd.getDate())
        let final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)
        $http.post('citas/get_citas', { day: d.getDay(), date: final_date })
        .success(res =>{
            console.log(res)
            if(res.status){
                vm.cita.slots_list = res.data
                for(let i in vm.cita.slots_list){
                    vm.cita.slots_list[i].init_slot = vm.ConvertTo12H(vm.cita.slots_list[i].init_slot)
                    vm.cita.slots_list[i].final_slot = vm.ConvertTo12H(vm.cita.slots_list[i].final_slot)
                }
                swal('¡Éxito!', res.msg, 'success')
            } else {
                swal('¡Atención!', res.msg, 'warning')
            }
        }).error(res=>{
            console.log(res)
            swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
        })
    }//

    vm.SelectCita = ind =>
    {
        if(vm.cita.selected === null){
            vm.cita.slots_list[ind].selected = true
            vm.cita.selected = vm.cita.slots_list[ind]
            vm.cita.selected.ind = ind
        }
    }//

    vm.DeselectCita = ind =>
    {
        vm.cita.slots_list[ind].selected = false
        vm.cita.selected = null
    }//vm.DeselectCita

    vm.SaveCita = _ =>
    {
        
        console.log('vm.cita.selected', vm.cita.selected)
        if(vm.cita.selected != null){
            vm.cita.selected.date = vm.ConvertToSimpleDate(vm.cita.date)

            $http.post('citas/save_cita', vm.cita.selected)
            .success(res =>{
                console.log(res)
                if(res.status){
                    vm.cita.selected = null;
                    vm.GetCitasByDate()
                    swal('Éxito', res.msg, 'success')
                } else {
                    swal('Atención', res.msg, 'warning')
                }
            }).error(res => {
                console.log(res)
                swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
            })
        } else {
            swal('Atención', res.msg, '¡Atención!')
        }
    }//vm.MakeCita

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

    vm.ConvertToSimpleDate = dd =>
    {
        let d = new Date(dd.getFullYear(), dd.getMonth(), dd.getDate())
        let final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)
        return final_date
    }//vm.ConvertToSimpleDate

}////