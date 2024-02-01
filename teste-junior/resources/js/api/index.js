import axios from "axios";

const api = axios.create({
    baseURL: 'http://localhost:8000/api/',
});

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
api.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
api.defaults.withCredentials = true;
api.defaults.withXSRFToken  = true;

export default api;
