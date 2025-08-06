import { useState } from "react";
import { checkoutCartItem } from "../../Services/addCart/checkoutService";

const useCheckout = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);
  const [orderData, setOrderData] = useState(null);

  const CheckoutCartItem = async (onSuccess) => {
    setIsLoading(true);
    setError(null);

    try {
      const data = await checkoutCartItem(); 
      setOrderData(data);
      console.log("Order Created:", data);

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
