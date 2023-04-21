import api from "../api";

export class Product {
    update(payload) {
        return new Promise((resolve, reject) => {
            api.put(`product/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        product: body,
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
        });
    }

    delete(payload) {
        return new Promise((resolve, reject) => {
            api.delete(`product/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        product: body,
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
                })
        });
    }

    get(uuid) {
        return new Promise((resolve, reject) => {
            api.get(`product/${uuid}`)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        product: body,
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

    store(payload) {
        return new Promise((resolve, reject) => {
            api.post('product', payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        product: body,
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
}
