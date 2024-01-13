import api from "../api";

export class Customer {
    update(payload) {
        return new Promise((resolve, reject) => {
            api.put(`customer/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        customer: body,
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
            api.delete(`customer/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        customer: body,
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
            api.get(`customer/${uuid}`)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        customer: body,
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
            api.post('customer', payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        customer: body,
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

    multiDelete(payload) {
        return new Promise((resolve, reject) => {
            api.delete(`multi-delete/customer`, {data: payload})
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        customer: body,
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
