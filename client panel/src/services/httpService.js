import axios from 'axios';
import {toast} from 'react-toastify';
axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.withCredentials = true;
axios.interceptors.response.use(null,error => {
    const expectedErrors = error.response && 
                            error.response.status >= 400 && 
                            error.response.status < 500;


    if (!expectedErrors) {
        toast.warning("مشکلی از سمت سرور پیش آمده است",{position:'top-right',closeOnClick:true});
    } else {
      toast.warning("خطا در دریافت اطلاعات",{position:'top-right',closeOnClick:true});
    }

    return Promise.reject(error);
});

export default {
    get : axios.get,
    post : axios.post,
    put : axios.put,
    delete : axios.delete,
};

    


