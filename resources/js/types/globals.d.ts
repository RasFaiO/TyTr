import type { route as routeFn } from 'ziggy-js';

declare global {
    const route: typeof routeFn;
    interface Window {
        Swal: typeof import('sweetalert2');
    }
}
