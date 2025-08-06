import { useState, useEffect } from "react";
import { getCategory } from "../../../src/Services/categoryService/categoryService"; 

const useCategories = () => {
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const response = await getCategory(); 
        setCategories(response.data.payload);
      } catch (err) {
        setError("Failed to load categories");
        setTimeout(() => {
          setError(null);
        }, 3000);
      } finally {
        setLoading(false);
      }
    };

    fetchCategories();
  }, []);

  return { categories, loading, error };
};

export default useCategories;