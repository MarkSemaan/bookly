import api from '../axios/useAxios'; 

export const addToCart = async (bookId, quantity = 1) => {
  const response = await api.post('/cartitems/cart', {
    book_id: bookId,
    quantity,
  });

  return response.data;
};
