import "./Assets/Styles/App.css";
import "./Assets/Styles/variable.css"
import BookDetails from "./Components/bookDetails/BookDetails";
import AppLayout from "./Components/Shared/Layouts/AppLayout";
import UserOrders from "./Components/userOrders/UserOrders";
import BookList from "./Pages/BookList/BookList";
import CreateBook from "./Pages/CreateBook";
import HomePage from "./Pages/HomePage/HomePage";
import Login from "./Pages/Login/Login";
import Register from "./Pages/Register/Register";
import OrderManagement from "./Components/orderManagement/OrderManagement";
import UserCart from "./Pages/UserCart/UserCart";

import {
  Routes,
  Route,
  useLocation,
} from "react-router-dom";
import BooksManagement from "./Pages/BooksManagement/BooksManagement";


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
          <Route path="/cart" element={<UserCart />} />

          <Route path="/createbook" element={<CreateBook />} />

          <Route path="/my_orders" element={<UserOrders />} />
          <Route path="/management" element={<OrderManagement />} />
          <Route path="/booksManagement" element={<BooksManagement />} />

        </Route>
      </Routes>
  );
};
