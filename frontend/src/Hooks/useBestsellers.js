import { useState, useEffect } from "react";
import api from "../../src/Services/bestseller/bestsellerService"; 

const useBestsellers = () => {
  const [bestsellers, setBestsellers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchBestsellers = async () => {
      setLoading(true);
      try {
        const response = await api.get("/user/books/toprated");  
        setBestsellers(response.data.payload);

      } catch (err) {
        setError("Failed to load bestsellers");
        console.error("Error fetching bestsellers:", err);
      } finally {
        setLoading(false);
      }
    };

    fetchBestsellers();
  }, []);

  return { bestsellers, loading, error };
};

export default useBestsellers;