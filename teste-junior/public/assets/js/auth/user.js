import { ApiManager } from "@/app.js";
const auth = ApiManager.auth;
const login = () => {
    const payload = getPayload($("#loginForm"));
    auth.login(payload)
        .then(response => {
            const { type, message} = response
            showAlert(type, message);
            goTo('home');
        })
        .catch(error => {
            const {type, message} = error;
            showAlert(type, message);
        });
}

const register = () => {
    const payload = getPayload($("#registerForm"));
    auth.register(payload)
        .then(response => {
            const { type, message} = response
            showAlert(type, message);
            goTo('home');
        })
        .catch(error => {
            const {type, message} = error;
            showAlert(type, message);
            goTo('/')
        });

}

window.userAuth = {};
window.userAuth.logout = () => {
    auth.logout()
        .catch(error => {
            const {type, message} = error;
            showAlert(type, message);
        });
}



$(".btn-create").on('click', register);
$(".btn-login").on('click', login);


