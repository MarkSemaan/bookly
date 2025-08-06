import React, { useRef } from 'react';
import useBooks from '../../Hooks/BookManagment/useBooks';
import BookCard from '../../Components/bookPage/allBooks/bookCard/BookCard';
import './booksManagement.css';

const BooksManagement = () => {
  const { books, loading, error, handleDelete } = useBooks();
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

  return (
    <div className="books-management-wrapper">
      <div className="header-with-button">
        <h1>Books Management</h1>
        <button className="create-btn">
          <a href="/createbook">Create Book</a>
        </button>
      </div>

      {loading ? (
        <p>Loading...</p>
      ) : error ? (
        <div className="error">{error}</div>
      ) : (
        <>
          <div className="books-container" ref={scrollRef}>
            {books.map((book) => (
              <BookCard
                key={book.id}
                book={book}
                isAdminCard={true}
                onDelete={handleDelete}
              />
            ))}
          </div>

          <div className="arrows">
            <button onClick={() => scroll('left')}>&lt;</button>
            <button onClick={() => scroll('right')}>&gt;</button>
          </div>
        </>
      )}
    </div>
  );
};

export default BooksManagement;
