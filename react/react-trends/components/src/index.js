import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import registerServiceWorker from './registerServiceWorker';
import * as version from './version';

const AvailableComponents = {
    App: App,
};

let reactElements = document.querySelectorAll('.react-component');
for (let i = 0; i < reactElements.length; i++) {
    let reactElement = reactElements[i];
    let reactComponentName = reactElement.getAttribute('data-element-name');
    if (reactComponentName && AvailableComponents[reactComponentName]) {
        ReactDOM.render(
            React.createElement(
                AvailableComponents[reactComponentName],
                reactElement.attributes,
            ),
            reactElement,
        );
    }
}

if (console) console.log('react-components', version);

registerServiceWorker();
