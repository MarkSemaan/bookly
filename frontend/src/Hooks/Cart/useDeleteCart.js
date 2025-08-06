import { useState } from "react";
import { deleteCartItemAPI } from "../../Services/addCart/userCartService";

const useDeleteCart = () => {
  const [deleting, setDeleting] = useState(false);
  const [error, setError] = useState(null);

  const deleteCartItem = async (itemId) => {
    setDeleting(true);
    setError(null);
    try {
      await deleteCartItemAPI(itemId);
      return true;
    } catch (err) {
      console.error("Error deleting cart item:", err);
      setError("Failed to delete cart item");
      return false;
    } finally {
      setDeleting(false);
    }
  };

  return { deleteCartItem, deleting, error };
};

export default useDeleteCart;
