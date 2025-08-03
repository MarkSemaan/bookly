import React from "react";
import { Link } from 'react-router-dom';
import "./bookCard.css";

const BookCard = ({ book }) => {
  const { title, price, rating, image } = book;


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
      
      <Link to={`/book/${book.id}`}>
        <button className="learn-more-btn">Learn More</button>
     </Link>

    </div>
  );
};

export default BookCard;
