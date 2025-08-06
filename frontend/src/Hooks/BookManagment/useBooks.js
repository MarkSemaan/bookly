import { useState, useEffect } from 'react';
import {fetchBooksFromApi, deleteBookById} from '../../Services/bookService/bookManagmentService';

const useBooks = () => {
  const [books, setBooks] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);
  

  useEffect(() => {
    fetchBooks();
  }, []);

  const fetchBooks = async () => {
    setLoading(true);
    try {
      const response = await fetchBooksFromApi();
      const fetchedBooks = response.data.payload.sort((a, b) => b.id - a.id);
      setBooks(fetchedBooks);
      setError(null);
    } catch (error) {
      setError(
        error?.response?.data?.message || 'Failed to fetch books'
      );
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (bookId) => {
    try {
      await deleteBookById(bookId);
      setBooks((prev) => prev.filter((book) => book.id !== bookId));
    } catch (err) {
      console.error('Delete failed:', err);
    }
  };

  return {
    books,
    loading,
    error,
    handleDelete,
  };
};

export default useBooks;
