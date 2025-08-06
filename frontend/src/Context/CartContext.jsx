import React, { createContext, useState, useEffect } from "react";
import { fetchUserCart, fetchUserCartTotal } from "../Services/addCart/userCartService";

export const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchCartData = async () => {
      setLoading(true);
      try {
        const cartData = await fetchUserCart();
        setCart(cartData);
        setError(null);
      } catch (err) {
        setError("Could not load cart data");
      } finally {
        setLoading(false);
      }
    };

    fetchCartData();
  }, []);

  useEffect(() => {
    const newTotal = cart.reduce((sum, item) => sum + item.book.price * item.quantity, 0);
    setTotal(newTotal);
  }, [cart]);

  return (
    <CartContext.Provider value={{ cart, setCart, total, loading, error }}>
      {children}
    </CartContext.Provider>
  );
};
