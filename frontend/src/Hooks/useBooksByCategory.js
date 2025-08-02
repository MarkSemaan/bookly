import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";

const useBooksByCategory = () => {
  const { category } = useParams(); 
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchBooks = async () => {
      setLoading(true);
      try {
        const res = await axios.get(`http://localhost:3000/books?category=${category}`);
        setBooks(res.data);
      } catch (err) {
        setError(err);
        console.error("Error fetching books: ", err);
      } finally {
        setLoading(false);
      }
    };

    fetchBooks();
  }, [category]);

  return { books, loading, error, category };
};

export default useBooksByCategory;
