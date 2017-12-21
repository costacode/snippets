import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import _ from 'lodash';

import Testing from './Testing';
import Test2 from './Test2';

const AvailableComponents = {
    Testing: Testing,
    Test2: Test2
};

//var str = 'my-hyphen-string';
//str = _.camelCase(str);
//var camelCased = myString.replace(/-([a-z])/g, function (g) { return g[1].toUpperCase(); });

let reactElements = document.querySelectorAll('.react-component');
for (let i = 0; i < reactElements.length; i++) {
    let reactElement = reactElements[i];
    let reactComponentName = reactElement.getAttribute('data-element');
    if (reactComponentName && AvailableComponents[reactComponentName]) {
        ReactDOM.render(
            React.createElement(
                AvailableComponents[reactComponentName],
                reactElement.attributes
            ),
            reactElement
        );
    }
}
