import http from './httpService';
import config from './config.json';

export const addTask = task => {
    return http.post(`${config.apiBaseURL}/api/task/add`,JSON.stringify(task));
}

export const taskList = () => {
    return http.get(`${config.apiBaseURL}/api/task/list`);
}