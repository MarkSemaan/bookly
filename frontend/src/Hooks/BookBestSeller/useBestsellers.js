import { useState, useEffect } from "react";
import { getBestsellers } from "../../Services/bookService/bestsellerService";

const useBestsellers = () => {
  const [bestsellers, setBestsellers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchBestsellers = async () => {
      setLoading(true);
      try {
        const response = await getBestsellers(); 
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
