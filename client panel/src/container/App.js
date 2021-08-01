import React from 'react';
import {BrowserRouter,Switch,Route} from 'react-router-dom';
import Login from '../components/Login';
import Calendar from '../components/Calendar';

function App() {

  return (
      <BrowserRouter>
        <Switch>
            <Route path="/" exact component={Login} />
            <Route path="/calendar" exact component={Calendar} />
        </Switch>
      </BrowserRouter>
  );
}

export default App;
