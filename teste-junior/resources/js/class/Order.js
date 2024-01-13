import api from "../api";

export class Order {
    update(payload) {
        return new Promise((resolve, reject) => {
            api.put(`order/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        order: body,
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
            api.delete(`order/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        order: body,
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
            api.get(`order/${uuid}`)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        order: body,
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
            api.post('order', payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        order: body,
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
            api.delete(`multi-delete/order`, {data: payload})
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        order: body,
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
