import { useState } from "react";
import api from "../Services/axios/useAxios";

const useDeleteCart = () => {
  const [deleting, setDeleting] = useState(false);
  const [error, setError] = useState(null);

 const deleteCartItem = async (itemId) => {
  setDeleting(true);
  setError(null);
  try {
    await api.delete(`/cartitems/delete/${itemId}`);
    setDeleting(false);
    return true;  
  } catch (err) {
    console.error("Error deleting cart item:", err);
    setError("Failed to delete cart item");
    setDeleting(false);
    return false; 
  }
};


  return { deleteCartItem, deleting, error };
};

export default useDeleteCart;
