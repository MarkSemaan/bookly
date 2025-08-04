import React from "react";
import { Link } from 'react-router-dom';
import "./bookCard.css";

const BookCard = ({ book }) => {
  const { title, price, rating, image } = book;
  const backendBaseUrl = "http://127.0.0.1:8000/";

  const stars = Array(5).fill(0).map((_, i) => (
    <span key={i} className={i < rating ? "star filled" : "star"}>
      &#9733;
    </span>
  ));

  return (
    <div className="book-card">
       <img src={image ? `${backendBaseUrl}${image}` : '/default-book.png'} className="book-card-image" />
      <h3 className="book-card-title">{title}</h3>
      <div className="book-card-rating">{stars}</div>
      <p className="book-card-price">${price}</p>
      
      <Link to={`/book/${book.id}`}>
        <button className="learn-more-btn">Learn More</button>
     </Link>

    </div>
  );
};

export default BookCard;
