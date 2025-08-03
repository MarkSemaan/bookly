import { useEffect, useState } from 'react';
import api from '../../src/Services/bookDetails/bookService';

const useBookDetails = (id) => {
  const [book, setBook] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchBook = async () => {
      try {
        const res = await api.get(`/user/books/book/${id}`);
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
