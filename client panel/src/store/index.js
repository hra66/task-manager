import { applyMiddleware, compose, createStore } from "redux";
import { persistStore, persistReducer } from 'redux-persist'
import storage from 'redux-persist/lib/storage' // defaults to localStorage for web
import {reducers} from './../reducers/index';

import thunk from "redux-thunk";

const persistConfig = {
    key: 'root',
    storage,
}
const persistedReducer = persistReducer(persistConfig, reducers);
let store = createStore(
    persistedReducer,
    compose(
        applyMiddleware(thunk),
       // window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
    )
);
let persistor = persistStore(store);
export default () => {
    return { store, persistor }
}


