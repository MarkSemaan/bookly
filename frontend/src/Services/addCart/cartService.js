import axios from 'axios';

const API_BASE = 'http://127.0.0.1:8000/api/v0.1';

export const addToCart = async (bookId, quantity = 1) => {
  const token = localStorage.getItem('token');

  const response = await axios.post(
    `${API_BASE}/cartitems/cart`,
    {
      book_id: bookId,
      quantity: quantity,
    },
    {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    }
  );

  return response.data;
};
