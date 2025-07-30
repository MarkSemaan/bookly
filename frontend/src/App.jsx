import "./Assets/Styles/App.css";
import "./Assets/Styles/variable.css"
import Navbar from "./Components/Shared/Navbar/Navbar";
import {
  Routes,
  Route,
  useLocation,
} from "react-router-dom";

const App = () => {
  const location = useLocation();

  return (
    <div className="App">
      <MyRoutes />
    </div>
  );
};

export default App;

const MyRoutes = () => {
  return (
    <Routes>
           <Route path="/navbar" element={<Navbar />} />
     
    </Routes>
  );
};
