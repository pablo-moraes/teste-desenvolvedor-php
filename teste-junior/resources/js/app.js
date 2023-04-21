import './bootstrap';

import '../sass/app.scss';

import {Product} from "./class/Product";

window.product = new Product();

const alertMessage = document.getElementById('alertMessage');

window.showAlert = (message) => {
    alertMessage.innerHTML = message;
    alertMessage.classList.add('show');
    alertMessage.classList.remove('hide');

    setTimeout(() => {
        hideAlert();
    }, 5000);
}

window.hideAlert = () => {
    alertMessage.innerHTML = '';
    alertMessage.classList.remove('show');
    alertMessage.classList.add('hide');
}
