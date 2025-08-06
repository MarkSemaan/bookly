import { useEffect, useState } from 'react';
import useAddToCart from '../Cart/useAddToCart';

const useCartHandlerForBookDetails = (bookId) => {
  const { handleAddToCart, loading, error } = useAddToCart();
  const [successMessage, setSuccessMessage] = useState('');

  const handleClick = async () => {
    const result = await handleAddToCart(bookId, 1);
    setSuccessMessage(result ? 'Added to cart!' : 'Failed to add to cart');
  };

  useEffect(() => {
    if (successMessage) {
      const timer = setTimeout(() => setSuccessMessage(''), 3000);
      return () => clearTimeout(timer);
    }
  }, [successMessage]);

  return { handleClick, successMessage, cartLoading: loading, cartError: error };
};

export default useCartHandlerForBookDetails;
