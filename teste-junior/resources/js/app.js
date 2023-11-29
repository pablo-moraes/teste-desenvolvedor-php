import './bootstrap';

import '../sass/app.scss';

import {Product} from "./class/Product";
import {Customer} from "./class/Customer";
import {Order} from "./class/Order";

window.instances = {
    product: new Product(),
    customer: new Customer(),
    order: new Order()
}


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
