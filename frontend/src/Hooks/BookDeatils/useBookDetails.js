import { useEffect, useState } from 'react';
import { getBookById } from '../../Services/bookService/bookDeatilsService'; 

const useBookDetails = (id) => {
  const [book, setBook] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!id) return;

    const fetchBook = async () => {
      setLoading(true);
      try {
        const res = await getBookById(id);
        setBook(res.data.payload);
        setError('');
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
