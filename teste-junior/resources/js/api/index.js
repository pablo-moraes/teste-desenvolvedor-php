import axios from "axios";

const api = axios.create({
    baseURL: 'http://localhost:8000/api/',
});

api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default api;
