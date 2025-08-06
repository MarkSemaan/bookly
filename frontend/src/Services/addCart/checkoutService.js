import api from "../axios/useAxios"; 

export const checkoutCartItem = async () => {
  const response = await api.post("/orders/from-cart");
  return response.data.data;
};
