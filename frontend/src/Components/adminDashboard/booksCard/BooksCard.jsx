import React from 'react';
import './booksCard.css';

const BooksCard = ({ title, books, showSales }) => {
  const backendBaseUrl = "http://127.0.0.1:8000/";
  return (
    <div className="books-card">
      <div className="books-card-header">
        <h3>{title}</h3>
        {showSales && <span className="sale-label">Sale</span>}
      </div>
      <div className="books-list">
        {books && books.map((book, index) => (
          <div key={index} className="book-item">
            <div className="book-cover">
              <img src={book.image ? `${backendBaseUrl}${book.image}` : '/default-book.png'}/>
            </div>
            <div className="book-info">
              <span className="book-title">{book.title}</span>
            </div>
            <div className="book-quantity">
              {book.quantity || book.sales}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default BooksCard;