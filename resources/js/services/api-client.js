import axios from 'axios';

const apiClient = axios.create({
    baseURL: process.env.MIX_API_URL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
    timeout: 10000,
});

export default apiClient;
