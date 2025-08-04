import React from "react";
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';
import "./bookCard.css";

const BookCard = ({ book, isAdminCard, onDelete }) => {
  const { title, price, rating, image } = book;
  const navigate = useNavigate();

  const stars = Array(5).fill(0).map((_, i) => (
    <span key={i} className={i < rating ? "star filled" : "star"}>
      &#9733;
    </span>
  ));

  return (
    <div className="book-card">
      <img src={image} alt={title} className="book-image" />
      <h3 className="book-title">{title}</h3>
      <div className="book-rating">{stars}</div>
      <p className="book-price">${price}</p>

      {isAdminCard ? (
        <div className="admin-btns">
          <button onClick={() => navigate('/edit_book')}>
            Edit
          </button>
          <button onClick={() => onDelete(book.id)}>
            Delete
          </button>
        </div>
      ) : (
        <Link to={`/book/${book.id}`}>
          <button className="learn-more-btn">Learn More</button>
        </Link>
      )}

    </div>
  );
};

export default BookCard;
