import api from "../../../api";

export class User {
    login(payload) {
        return new Promise((resolve, reject) => {
            api.post('/user/login', payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        type,
                        message
                    });
                })
                .catch(err => {
                    const {errors, message, type} = err.response.data;
                    reject({
                        data: {...errors},
                        type,
                        message
                    });
                });
        })
    }

    register(payload) {
        return new Promise((resolve, reject) => {
            api.post('/user/register', payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        type,
                        message
                    });
                })
                .catch(err => {
                    const {errors, message, type} = err.response.data;
                    reject({
                        data: {...errors},
                        type,
                        message
                    });
                });
        })
    }

    logout() {
        return new Promise((resolve, reject) => {
            api.post('/user/logout')
                .then(response => {
                    goTo('/')
                })
                .catch(err => {
                    const {errors, message, type} = err.response.data;
                    reject({
                        data: {...errors},
                        type,
                        message
                    });
                });
        });
    }
}
