type FlashMessageType = 'created' | 'updated' | 'deleted' | 'deletedError';

const bodyColor = '#041233';
const textColor = '#fff';
const botonConfirmar = '#6467f2';
const botonCancelar = '#e11d48';

export function useSweetAlert() {
  const showFlashAlert = (type: FlashMessageType) => {
    const isError = type === 'deleted' || type === 'deletedError';
    const config = {
      position: 'top-end' as const,
      icon: isError ? 'error' : 'success',
      showConfirmButton: false,
      color: textColor,
      background: bodyColor,
      timer: 2000,
    };

    let title = '';
    switch (type) {
      case 'created':
        title = 'Registro creado satisfactoriamente';
        break;
      case 'updated':
        title = 'Registro actualizado satisfactoriamente';
        break;
      case 'deleted':
        title = 'El registro ha sido eliminado';
        break;
      case 'deletedError':
        title = 'No se puede eliminar el registro';
        break;
    }
    window.Swal.fire({ ...config, title });
  };

  const confirmDelete = async (): Promise<boolean> => {
    const result = await window.Swal.fire({
      title: '¿Estás Seguro?',
      text: 'No podrás recuperar los datos!',
      icon: 'warning',
      showCancelButton: true,
      color: textColor,
      background: bodyColor,
      confirmButtonColor: botonConfirmar,
      cancelButtonColor: botonCancelar,
      confirmButtonText: 'Sí, Borrar',
      cancelButtonText: 'Cancelar',
    });

    return result.isConfirmed;
  };

  const isValidMessage = (msg: string): msg is FlashMessageType => {
    return ['created', 'updated', 'deleted', 'deletedError'].includes(msg);
  };

  return {
    showFlashAlert,
    confirmDelete,
    isValidMessage,
  };
}
