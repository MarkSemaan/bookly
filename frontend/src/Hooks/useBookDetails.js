import { useEffect, useState } from 'react';
import { getBooks } from '../api';

const useBookDetails = (id) => {
  const [book, setBook] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchBook = async () => {
      try {
        const res = await getBooks(id);
        setBook(res.data.payload);
      } catch (err) {
        setError('Failed to load book');
      } finally {
        setLoading(false);
      }
    };
    fetchBook();
  }, [id]);

  return { book, error, loading };
};

export default useBookDetails;
