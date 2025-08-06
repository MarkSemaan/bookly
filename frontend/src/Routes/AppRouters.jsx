import "../Assets/Styles/App.css";
import "../Assets/Styles/variable.css"

import BookDetails from "../Pages/BookDetails/BookDetails";
import AppLayout from "../Components/Shared/Layouts/AppLayout";
import UserOrders from "../Pages/UserOrder/UserOrder";
import BookList from "../Pages/BookList/BookList";
import HomePage from "../Pages/HomePage/HomePage";
import Login from "../Pages/Login/Login";
import Register from "../Pages/Register/Register";
import UserCart from "../Pages/UserCart/UserCart";
import OrderManagement from "../Pages/OrderManagement/OrderManagement";
import BooksManagement from "../Pages/BooksManagement/BooksManagement";
import CreateBook from "../Pages/CreateBook/CreateBook";
import EditBook from "../Pages/EditBook/EditBook";



import {
  Routes,
  Route
} from "react-router-dom";
import AdminDashboard from "../Pages/AdminDashboard/AdminDashboard";


const AppRouters = () => {
  return (
    <div className="App">
      <MyRoutes />
    </div>
  );
};

export default AppRouters;

const MyRoutes = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route element={<AppLayout />}>
      <Route path="/" element={<HomePage />} />
      <Route path="/bookList" element={<BookList />} />
      <Route path="/book/:id" element={<BookDetails />} />
      <Route path="/cart" element={<UserCart />} />
      <Route path="/createbook" element={<CreateBook />} />
      <Route path="/editbook/:id" element={<EditBook />} />
      <Route path="/my_orders" element={<UserOrders />} />
      <Route path="/management" element={<OrderManagement />} />
      <Route path="/booksManagement" element={<BooksManagement />} />
      <Route path="/dashbored" element={<AdminDashboard />} />

    </Route>
    </Routes>
  );
};
