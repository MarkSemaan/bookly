import React, { useRef } from "react";
import useBestsellers from "../../../../Hooks/useBestsellers";
import BookCard from "../bookCard/BookCard";


const Bestsellers = () => {
  const { bestsellers, loading } = useBestsellers();
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

  if (loading) return <p>Loading bestsellers...</p>;

  return (
    <section className="bestsellers-section">
      <div className="bestsellers-header">
        <h2>Bestselling Books</h2>
       
      </div>

      <div className="bestsellers-container" ref={scrollRef}>
        {bestsellers.map((book) => (
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

export default Bestsellers;
