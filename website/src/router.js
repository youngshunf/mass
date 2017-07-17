import React from 'react';
import IndexPage from './routes/Home';
import Download from './routes/Download';
import {Router, Route, IndexRoute, IndexRedirect, Link} from 'dva/router';
function RouterConfig({ history }) {
  return (
    <Router history={history}>
      <Route path="/" component={IndexPage} />
      <Route path="/download">
        	<IndexRoute component={Download} />
       </Route>
    </Router>
  );
}

export default RouterConfig;
