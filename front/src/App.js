import "antd/dist/antd.css";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Logout from "./components/Logout";
import { Login, Home, Deposit, Withdraw, Trasnfer, Transactions} from "./pages";
function App() {
  return (
    <Router>
      <div className="App"></div>

      <Switch>
        <Route path="/login">
          <Login />
        </Route>
        <Route path="/home">
          <Home />
        </Route>
        <Route path="/deposit">
          <Deposit />
        </Route>
        <Route path="/withdraw">
          <Withdraw />
        </Route>
        <Route path="/transfer">
          <Trasnfer />
        </Route>
        <Route path="/logout">
          <Logout />
        </Route>
        <Route path="/transactions">
          <Transactions />
        </Route>
      </Switch>
    </Router>
  );
}

export default App;
