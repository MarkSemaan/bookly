import { useState } from 'react';
import { addToCart } from '../../src/Services/addCart/cartService';

export const useAddToCart = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleAddToCart = async (bookId, quantity = 1) => {
    try {
      setLoading(true);
      setError(null);

      const result = await addToCart(bookId, quantity);
      return result;
    } catch (err) {
      console.error('Error adding to cart:', err);
      setError(err.response?.data || 'Unknown error');
    } finally {
      setLoading(false);
    }
  };

  return { handleAddToCart, loading, error };
};
export default useAddToCart;