import { useState } from 'react';
import { addOrUpdateCartItem } from '../../api';

export default function useAddToCart() {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  async function handleAddToCart(bookId, quantity = 1) {
    setLoading(true);
    setError(null);

    try {
      if (!bookId) throw new Error('Invalid book ID');
      await addOrUpdateCartItem({ book_id: bookId, quantity });
      return true;
    } catch (err) {
      console.error('Error adding to cart:', err);
      if (err.response?.data?.message) {
        setError(err.response.data.message);
      } else if (err.message) {
        setError(err.message);
      } else {
        setError('Unknown error adding to cart.');
      }
      return false;
    } finally {
      setLoading(false);
    }
  }

  return { handleAddToCart, loading, error };
}
