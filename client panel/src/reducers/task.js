export const taskReducer = (state = [], action) => {
    switch (action.type) {
        case 'SET_USER_TASKS':
            return {...action.payload};
        default:
            return state;
    }
};
  