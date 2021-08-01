import React, { useEffect, useState } from 'react';
import FullCalendar from '@fullcalendar/react'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from "@fullcalendar/interaction"
import { useSelector } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import { logoutUser } from './../actions/user.js';
import { addTask } from '../services/taskServices.js';
import {setUserTasks} from './../actions/task.js';


const Calendar = (props) => {
    const userTasks = useSelector(state => state.task);
    const user = useSelector(state => state.user);
    const [taskTitle, settaskTitle] = useState(null);
    const [taskDescription, settaskDescription] = useState('');
    const [showNewTask, setshowNewTask] = useState(false);
    const [selectedDate, setselectedDate] = useState(null);

    const dispatch = useDispatch();
    let tasks = [];
    const handleColor = (statusText) => {
        if (statusText == 'accept') {
            return '#0e9b01';
        } else if (statusText == 'reject') {
            return '#fb414a';
        } else {
            return '#f7c52e';
        }
    }

   

    const handleDateClick = (arg) => {
        setshowNewTask(true);
        setselectedDate(arg);
    }

    const handleEventClick = (arg) => {
    }

    const handleNewTaskForm = async (e) => {
        e.preventDefault();
        if(taskTitle){
            let formData = {
                'title':taskTitle,
                'description':taskDescription,
                'date':selectedDate.dateStr,
            }
            try {
                const { status, data } = await addTask(formData);
                if (status === 200) {
                    dispatch(setUserTasks(data.data.tasks));
                    window.location.reload();
                }
            } catch (ex) {
            }
        }else{
            alert('Please fill task title');
        }
    }
    if (userTasks) {
        for( var key in userTasks){
            var obj = userTasks[key];
            tasks.push({
                'id': obj.id,
                'title': obj.title,
                'start': obj.start,
                'color': handleColor(obj.status_text)
            })
        }
    } 
    const handleLogout = () => {
        dispatch(logoutUser());
        props.history.push("/");
    }
    return (

        user && user.email ? (
            <div className="container">
                <div className="row mt-5" >
                    <div className="col-6">
                        <h4>Welcome : {user.email} </h4>
                    </div>
                    <div className="col-6 text-right">
                        <button className="btn btn-sm btn-danger" onClick={handleLogout}> Logout</button>
                    </div>
                </div>
                {showNewTask ? (
                    <div className="row">
                        <div className="col-12 pt-5 pb-5">
                            <div className="card">
                                <div className="card-header">New Task :  {selectedDate && selectedDate.dateStr}</div>
                                <div className="card-body">
                                    <form onSubmit={handleNewTaskForm}>
                                        <div class="input-group mb-3">
                                            <input type="text" name="title" value={taskTitle}  onChange={e=>settaskTitle(e.target.value)} className="form-control"  placeholder="title"/>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="text" name="description"  value={taskDescription}  onChange={e=>settaskDescription(e.target.value)}  className="form-control"  placeholder="description"/>
                                        </div>
                                        <div class="input-group mb-3">
                                            <button type="submit" className="btn btn-success btn-sm">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ) : null}
                <div className="row">
                    <div className="col-12 pt-5 pb-5">
                        <FullCalendar
                            plugins={[dayGridPlugin, interactionPlugin]}
                            initialView="dayGridMonth"
                            initialEvents={tasks} // alternatively, use the `events` setting to fetch from a feed
                            dateClick={handleDateClick}
                            eventClick={handleEventClick}
                        />
                    </div>
                </div>
            </div>
        ) : null


    );
}

export default withRouter(Calendar);