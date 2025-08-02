import "./Assets/Styles/App.css";
import "./Assets/Styles/variable.css"
import AppLayout from "./Components/Shared/Layouts/AppLayout";
import Navbar from "./Components/Shared/Navbar/Navbar";
<<<<<<< HEAD
=======
import BookList from "./Pages/BookList/BookList";
>>>>>>> 291075876d39d9c5c313b90c32097c4d31da09a2
import HomePage from "./Pages/HomePage/HomePage";
import Login from "./Pages/Login/Login";
import Register from "./Pages/Register/Register";


<<<<<<< HEAD
=======

>>>>>>> 291075876d39d9c5c313b90c32097c4d31da09a2
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
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route element={<AppLayout />}>
      <Route path="/homePage" element={<HomePage />} />
<<<<<<< HEAD
          
=======
          <Route path="/bookList" element={<BookList />} />
>>>>>>> 291075876d39d9c5c313b90c32097c4d31da09a2
        </Route>
      </Routes>
  );
};
