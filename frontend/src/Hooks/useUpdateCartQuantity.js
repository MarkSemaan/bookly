import { useState } from 'react';
import api from '../../src/Services/axios/useAxios'; 

const useUpdateCartQuantity = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const decreaseQuantity = async (bookId) => {
    try {
      setLoading(true);
      const response = await api.post('/cartitems/decrease', { book_id: bookId });
      return response.data.item || true;
     
    } catch (err) {
      setError('Failed to decrease quantity');
      console.error(err);
      return null;
    } finally {
      setLoading(false);
    }
  };

  return { decreaseQuantity, loading, error };
};

export default useUpdateCartQuantity;
