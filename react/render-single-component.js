// MyComponent.js FILE

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const MyComponent = () => {
    return (
        <div className="my-new-component">
            <h3>Hello, My Component!</h3>
        </div>
    );
};

ReactDOM.render(
    React.createElement(MyComponent),
    document.getElementById('my-component')
);

// ON THE main.js FILE
import MyComponent from './../../../react/components/src/testing/MyComponent';
// import MyComponent from './../../../react/components/src/index';

var $ = jQuery;
var w = $(window);
var STORAGE_KEY = 'members/legend';
//...
