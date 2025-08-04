import React, { useState, useEffect, createContext } from "react";
import { getUserCartItems, getCartTotal } from "../api";

export const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchCart = async () => {
      setLoading(true);
      try {
        const res = await getUserCartItems();
        setCart(res.data.payload || []);
        const totalRes = await getCartTotal();
        setTotal(totalRes.data.payload || 0);
      } catch (err) {
        setError("Could not load cart");
      } finally {
        setLoading(false);
      }
    };

    fetchCart();
  }, []);

  useEffect(() => {
    const newTotal = cart.reduce(
      (sum, item) => sum + item.book.price * item.quantity,
      0
    );
    setTotal(newTotal);
  }, [cart]);

  return (
    <CartContext.Provider value={{ cart, setCart, total, loading, error }}>
      {children}
    </CartContext.Provider>
  );
};
