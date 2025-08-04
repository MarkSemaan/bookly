import { useState, useEffect } from "react";
import api from "../../src/Services/axios/useAxios";

const useUserCart = () => {
  const [cart, setCart] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);


  useEffect(() => {
    const fetchCartData = async () => {
      setLoading(true);
      try {
        const cartResponse = await api.get("/cartitems/user/cart");
        setCart(cartResponse.data.payload || []);

        const totalResponse = await api.get("/cartitems/total/cart");
        setTotal(totalResponse.data.payload || 0);
      } catch (err) {
        setError("Failed to load cart data");
        console.error("Error fetching cart or total:", err);
      } finally {
        setLoading(false);
      }
    };

    fetchCartData();
  }, []);

  useEffect(() => {
    const newTotal = cart.reduce((sum, item) => {
      return sum + (item.book.price * item.quantity);
    }, 0);
    setTotal(newTotal);
  }, [cart]);

  return { cart, total, loading, error, setCart };
};

export default useUserCart;
