import { useState } from "react";
import { decreaseCartQuantityAPI } from "../../Services/addCart/userCartService";

const useUpdateCartQuantity = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const decreaseQuantity = async (bookId) => {
    setLoading(true);
    try {
      return await decreaseCartQuantityAPI(bookId);
    } catch (err) {
      console.error("Error decreasing quantity:", err);
      setError("Failed to decrease quantity");
      return null;
    } finally {
      setLoading(false);
    }
  };

  return { decreaseQuantity, loading, error };
};

export default useUpdateCartQuantity;
