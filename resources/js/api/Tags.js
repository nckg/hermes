/* eslint-disable no-undef */
import { Client } from './Client';

const client = new Client();

export default {
    all(params = {}) {
        return client.get(route('api::tags.index'), { params });
    },
};
