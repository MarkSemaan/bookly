import React, { useRef } from "react";
import useBooksByCategory from "../../../../Hooks/useBooksByCategory"; 
import BookCard from "../bookCard/BookCard";


const Books = () => {
  const { books, loading, error, category } = useBooksByCategory();

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



  if (loading) return <p>Loading books...</p>;
  if (error) return <p>Failed to load books</p>;

  return (
  
  <section className="bestsellers-section">
      <div className="bestsellers-header">
      <h2>{category} Books</h2>
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