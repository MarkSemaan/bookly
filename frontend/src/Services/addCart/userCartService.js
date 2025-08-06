import api from "../axios/useAxios";

export const fetchUserCart = async () => {
  const response = await api.get("/cartitems/user/cart");
  return response.data.payload || [];
};

export const fetchUserCartTotal = async () => {
  const response = await api.get("/cartitems/total/cart");
  return response.data.payload || 0;
};

export const deleteCartItemAPI = async (itemId) => {
  await api.delete(`/cartitems/delete/${itemId}`);
};

export const decreaseCartQuantityAPI = async (bookId) => {
  const response = await api.post("/cartitems/decrease", {
    book_id: bookId,
  });
  return response.data.item || true;
};
