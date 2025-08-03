import { useState } from "react";
import api from "../Services/axios/useAxios";
const useCheckout = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);
  const [orderData, setOrderData] = useState(null);

  const CheckoutCartItem = async (onSuccess) => {  
    setIsLoading(true);
    setError(null);

    try {
      const response = await api.post("/orders/from-cart");
      setOrderData(response.data.data);
      console.log("Order Created:", response.data);

      if (onSuccess) onSuccess();  

    } catch (err) {
      console.error("Error during checkout:", err);
      setError(err.response?.data?.message || "Failed to checkout cart item");
    } finally {
      setIsLoading(false);
    }
  };

  return { CheckoutCartItem, isLoading, error, orderData };
};


export default useCheckout;
