import React,{useState} from 'react';
import {withRouter} from 'react-router-dom';
import { useDispatch } from 'react-redux';
import {setUser} from './../actions/user.js';
import {setUserTasks} from './../actions/task.js';
import { loginUser } from '../services/userServices';

const Login = (props) => {
    const [email, setemail] = useState('');
    const [password, setpassword] = useState('');
    const [loading, setloading] = useState(false);
    const dispatch = useDispatch();
    const handleSubmit = async (e)=>{
        e.preventDefault();
        if(email && password){
            const formData = {
                email,
                password,
            };
            try {
                setloading(true);
                const { status, data } = await loginUser(formData);
                console.log(data);
                if (status === 200) {
                    dispatch(setUser(data.data.user));
                    dispatch(setUserTasks(data.data.user.tasks));
                    setloading(false);
                    props.history.push("/calendar");
                }
            } catch (ex) {
                setloading(false);
            }
        }else{
            alert('Please fill in both email and password');
        }
       
    }
    return (
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 pt-5 mx-auto">
                    <h3 class="text-center mb-5">Task Management</h3>
                    <form onSubmit={handleSubmit}>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                <input type="text"  value={email} onChange={e=>setemail(e.target.value)} class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" />
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">P</span>
                                </div>
                                <input type="password" value={password} onChange={e=>setpassword(e.target.value)}  class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" />
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-success btn-block" >Login</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    );
}

export default withRouter(Login);