import { fetchChamadas } from './fetchChamadas.js';
import { handleChamada } from './handleChamada.js';
import { updateAtendimento } from './updateAtendimento.js';

document.addEventListener('DOMContentLoaded', () => {
    fetchChamadas();
});
