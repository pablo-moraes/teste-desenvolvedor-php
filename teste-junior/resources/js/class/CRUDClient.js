import api from "../api";
export class CRUDClient {
    update(payload, endpoint) {
        return new Promise((resolve, reject) => {
            api.put(`${endpoint}/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        [endpoint]: body,
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
    delete(payload, endpoint) {
        return new Promise((resolve, reject) => {
            api.delete(`${endpoint}/${payload.uuid}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        [endpoint]: body,
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
    get(uuid, endpoint) {
        return new Promise((resolve, reject) => {
            api.get(`${endpoint}/${uuid}`)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        [endpoint]: body,
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
    save(payload, endpoint) {
        return new Promise((resolve, reject) => {
            api.post(`${endpoint}`, payload)
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        [endpoint]: body,
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
    multiDelete(payload, endpoint) {
        return new Promise((resolve, reject) => {
            api.delete(`multi-delete/${endpoint}`, {data: payload})
                .then(response => {
                    const {body, type, message} = response.data;
                    resolve({
                        [endpoint]: body,
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
