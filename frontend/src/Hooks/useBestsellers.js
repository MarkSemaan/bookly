import { useState, useEffect } from "react";
import { books } from "../../src/fakeData"; 

const useBestsellers = () => {
  const [bestsellers, setBestsellers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    setTimeout(() => {
      setBestsellers(books.slice(0, 5)); 
      setLoading(false);
    }, 500);
  }, []);

  return { bestsellers, loading };
};

export default useBestsellers;

// import { useState, useEffect } from "react";
// import { getAllBooks } from "../../Services/books/bookService";  // adjust path

// const useBestsellers = () => {
//   const [bestsellers, setBestsellers] = useState([]);
//   const [loading, setLoading] = useState(true);
//   const [error, setError] = useState(null);

//   useEffect(() => {
//     const fetchBestsellers = async () => {
//       setLoading(true);
//       try {
//         const response = await getAllBooks();  
//         setBestsellers(response.data.slice(0, 5));  
//       } catch (err) {
//         setError("Failed to load bestsellers");
//         console.error("Error fetching bestsellers:", err);
//       } finally {
//         setLoading(false);
//       }
//     };

//     fetchBestsellers();
//   }, []);

//   return { bestsellers, loading, error };
// };

// export default useBestsellers;