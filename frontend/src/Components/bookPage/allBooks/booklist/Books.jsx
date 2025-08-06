import { useRef } from "react";
import useBooksByCategory from "../../../../Hooks/BooksByCategory/useBooksByCategory"; 
import BookCard from "../bookCard/BookCard";

const Books = ({ categoryId,categoryName }) => {
  const { books, loading, error } = useBooksByCategory(categoryId);
  const scrollRef = useRef();

  const scroll = (direction) => {
    if (scrollRef.current) {
      const scrollAmount = 300; 
      scrollRef.current.scrollBy({
        left: direction === "left" ? -scrollAmount : scrollAmount,
        behavior: "smooth",
      });
    }
  };


  return (
    <section className="bestsellers-section">
      {error && <p style={{ color: "red" }}>{error}</p>}
      {loading && <p>Loading categories...</p>}
      <div className="bestsellers-header">
         <h2>{categoryName} Books</h2>
      </div>

      <div className="bestsellers-container" ref={scrollRef}>
        {books.map((book) => (
          <BookCard key={book.id} book={book} />
        ))}
      </div>

      <div className="arrows">
        <button onClick={() => scroll("left")}>&lt;</button>
        <button onClick={() => scroll("right")}>&gt;</button>
      </div>
    </section>
  );
};

export default Books;
