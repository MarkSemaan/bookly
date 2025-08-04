
import { Routes, Route } from "react-router-dom";
import AppLayout from "../Components/Shared/Layouts/AppLayout";
import HomePage from "../Pages/HomePage/HomePage";
import BookList from "../Pages/BookList/BookList";
import BookDetails from "../Components/bookDetails/BookDetails";
import UserCart from "../Pages/UserCart/UserCart";
import Login from "../Pages/Login/Login";
import Register from "../Pages/Register/Register";

const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />

      <Route element={<AppLayout />}>
        <Route path="/" element={<HomePage />} />
        <Route path="/bookList" element={<BookList />} />
        <Route path="/book/:id" element={<BookDetails />} />
        <Route path="/cart" element={<UserCart />} />
      </Route>
    </Routes>
  );
};

export default AppRoutes;
