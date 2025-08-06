import ReactDOM from "react-dom/client";
import "./Assets/Styles/index.css";
import App from "./App.jsx";
import { BrowserRouter } from "react-router-dom";
import { ThemeProvider } from './Context/ThemeContext.jsx';
import { CartProvider } from "./Context/CartContext.jsx";
import { UserProvider } from "./Context/UserContext.jsx";


const rootElement = document.getElementById("root");
const root = ReactDOM.createRoot(rootElement);

root.render(
  <BrowserRouter>
   <ThemeProvider>
    <UserProvider>
    <CartProvider>
      <App />
    </CartProvider>
    </UserProvider>
   </ThemeProvider>
  </BrowserRouter>
);
