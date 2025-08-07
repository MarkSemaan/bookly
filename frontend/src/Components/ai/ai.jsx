import React, { useEffect, useState, useRef } from 'react';
import BookCard from '../../Components/bookPage/allBooks/bookCard/BookCard';
import { getRecommendedBooks } from '../../Services/Ai/bookAi';

const RecommendedBooks = () => {
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const scrollRef = useRef();

  const scroll = (direction) => {
    if (scrollRef.current) {
      const scrollAmount = 300;
      scrollRef.current.scrollBy({
        left: direction === 'left' ? -scrollAmount : scrollAmount,
        behavior: 'smooth',
      });
    }
  };

  useEffect(() => {
    getRecommendedBooks()
      .then(data => {
        if (data.status === 'success') {
          const cleanBooks = (data.payload || []).filter(book => book && book.id);
          setBooks(cleanBooks);
        } else {
          setError('Unexpected response format');
        }
        setLoading(false);
      })
      .catch(err => {
        setError('Failed to fetch recommended books');
        setLoading(false);
        console.error(err);
      });
  }, []);

  if (loading) return <p>Loading recommendations...</p>;
  if (error) return <p className="text-red-500 font-semibold">{error}</p>;

  return (
    <section className="bestsellers-section">
      <div className="bestsellers-header">
        <h2>Recommended for You</h2>
      </div>

      <div className="bestsellers-container" ref={scrollRef}>
        {books.map(book => (
          <BookCard key={book.id} book={book} />
        ))}
      </div>

      <div className="arrows">
        <button onClick={() => scroll('left')}>&lt;</button>
        <button onClick={() => scroll('right')}>&gt;</button>
      </div>
    </section>
  );
};

export default RecommendedBooks;
