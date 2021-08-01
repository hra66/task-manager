import {combineReducers} from "redux";
import { userReducer } from "./user";
import { taskReducer } from "./task";

export const reducers = combineReducers({
    user : userReducer,
    task : taskReducer,
});