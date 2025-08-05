import React, { useState, useEffect, useRef } from 'react';
import SearchBox from '../../Components/SearchBar/SearchBar';
import BookCard from '../../Components/bookPage/allBooks/bookCard/BookCard';
import { searchBooks, getBooks } from '../../api';
import './BookPage.css';

export default function BooksPage() {
  const [searchTerm, setSearchTerm] = useState('');
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const scrollRef = useRef();

  useEffect(() => {
    const fetchAllBooks = async () => {
      setLoading(true);
      setError(null);
      try {
        const res = await getBooks();
        setBooks(Array.isArray(res.data.payload) ? res.data.payload : []);
      } catch (err) {
        setError('Failed to fetch books. Please try again later.');
      } finally {
        setLoading(false);
      }
    };

    if (searchTerm.trim() === '') {
      fetchAllBooks();
    }
  }, [searchTerm]);

  useEffect(() => {
    if (searchTerm.trim() === '') return;

    const fetchBooks = async () => {
      setLoading(true);
      setError(null);
      try {
        const res = await searchBooks({ search: searchTerm });
        setBooks(Array.isArray(res.data.payload) ? res.data.payload : []);
      } catch (err) {
        setError('Failed to fetch books. Please try again later.');
      } finally {
        setLoading(false);
      }
    };

    const debounceTimer = setTimeout(() => {
      fetchBooks();
    }, 400);

    return () => clearTimeout(debounceTimer);
  }, [searchTerm]);

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
    <div className="bestsellers-section">
      <div className="bestsellers-header">
        <h1>Book Finder</h1>
        <SearchBox
          placeholder="Search by title, author or publisher…"
          onChangeHandler={(e) => setSearchTerm(e.target.value)}
        />
      </div>

      <div className="bestsellers-container" ref={scrollRef}>
        {loading && <p className="loading-message">Loading books…</p>}
        {error && <p className="error-message">{error}</p>}
        {!loading && !error && books.length > 0 &&
          books.map((book) => (
            <BookCard key={book.id} book={book} />
          ))
        }
        {!loading && !error && books.length === 0 &&
          <p className="no-results-message">No books matched your search.</p>
        }
      </div>

      <div className="arrows">
        <button onClick={() => scroll("left")}>&lt;</button>
        <button onClick={() => scroll("right")}>&gt;</button>
      </div>
    </div>
  );
}