import React from 'react';
import ReactDOM from 'react-dom/client';
import './../css/app.css';
import LoginWidget from './components/wingets/LoginWidget.tsx';

const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(
    <div className='background'>
        <LoginWidget/>
    </div>
);