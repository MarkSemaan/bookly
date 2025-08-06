import { useEffect, useState } from "react";
import { getBookByCategoryId } from "../../../src/Services/bookService/bookByCategoryService"; 

const useBooksByCategory = (categoryId) => {
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (!categoryId) return;

    const fetchBooks = async () => {
      setLoading(true);
      try {
        const res = await getBookByCategoryId(categoryId); 
        setBooks(res.data.payload);
        setError(null);
      } catch (err) {
        const msg = err.response?.data?.message || err.message || "Failed to load books";
        setError(msg);

        setTimeout(() => setError(null), 3000);
      } finally {
        setLoading(false);
      }
    };

    fetchBooks();
  }, [categoryId]);

  return { books, loading, error };
};

export default useBooksByCategory;