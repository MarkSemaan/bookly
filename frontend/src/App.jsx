import "./Assets/Styles/App.css";
import "./Assets/Styles/variable.css"
import BookDetails from "./Components/bookDetails/BookDetails";
import AppLayout from "./Components/Shared/Layouts/AppLayout";
import BookList from "./Pages/BookList/BookList";
import HomePage from "./Pages/HomePage/HomePage";
import Login from "./Pages/Login/Login";
import Register from "./Pages/Register/Register";


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
          <Route path="/bookList" element={<BookList />} />
          <Route path="/book/:id" element={<BookDetails />} />
        </Route>
      </Routes>
  );
};
