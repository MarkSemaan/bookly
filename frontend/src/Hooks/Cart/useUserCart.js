import { useContext } from "react";
import { CartContext } from "../../Context/CartContext";

const useUserCart = () => {
  return useContext(CartContext);
};

export default useUserCart;
