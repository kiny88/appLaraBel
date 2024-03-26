function confirmEliminarCita(form){
    Swal.fire({
        icon: 'warning',
        title: '¿Estás seguro de borrar la cita?',
        text: 'Esta acción no se puede deshacer',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar cita',
        cancelButtonText: 'Cancelar'
    })
    .then((result) => {
        if(result.isConfirmed){
            Swal.fire({
                icon: 'success',
                title: 'Cita Eliminada',
                text: 'La cita fue eliminada correctamente',
                button: 'OK'
            })
            .then(() => {
                form.submit();
            });
        }else if(result.isDenied){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al eliminar la cita'
            });
        }
    });
}

function confirmEliminarServicio(form){
    Swal.fire({
        icon: 'warning',
        title: '¿Estás seguro de borrar el servicio?',
        text: 'Esta acción no se puede deshacer',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar servicio',
        cancelButtonText: 'Cancelar'
    })
    .then((result) => {
        if(result.isConfirmed){
            Swal.fire({
                icon: 'success',
                title: 'Servicio Eliminado',
                text: 'El servicio fue eliminado correctamente',
                button: 'OK'
            })
            .then(() => {
                form.submit();
            });
        }else if(result.isDenied){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al eliminar el servicio'
            });
        }
    });
}