// Render components only when they have a class of 'react-component'
// and an attributte with a value equal to the actual component name.
// example markup: <div class='react-component' component-name='RanTest'></div>
// if (reactComponentName && AvailableComponents[reactComponentName]) {
//     ReactDOM.render(
//         React.createElement(
//             AvailableComponents[reactComponentName],
//             reactElement.attributes
//         ),
//         reactElement
//     );
// }

reactComponentName && AvailableComponents[reactComponentName]
    ? ReactDOM.render(
          React.createElement(
              AvailableComponents[reactComponentName],
              reactElement.attributes
          ),
          reactElement
      )
    : null;
