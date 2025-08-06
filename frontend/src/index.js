import React from "react";
import ReactDOM from "react-dom/client";
import "./Assets/Styles/index.css";
import App from "./App.jsx";
import { BrowserRouter } from "react-router-dom";
import { ThemeProvider } from './Context/ThemeContext.jsx';
import { AuthProvider } from './Context/AuthContext.jsx';
import { CartProvider } from "./Context/CartContext.jsx";

const rootElement = document.getElementById("root");
const root = ReactDOM.createRoot(rootElement);

root.render(
  <BrowserRouter>
  <CartProvider>
  <AuthProvider>
   <ThemeProvider>
      <App />
   </ThemeProvider>
   </AuthProvider>
   </CartProvider>
  </BrowserRouter>
);
