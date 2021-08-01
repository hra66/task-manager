import http from './httpService';
import config from './config.json';

export const loginUser = user => {
    return http.post(`${config.apiBaseURL}/api/auth/login`,JSON.stringify(user));
}