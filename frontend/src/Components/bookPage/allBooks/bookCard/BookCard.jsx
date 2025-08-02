import React from "react";
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
      <p className="book-price">${price.toFixed(2)}</p>
      <button className="learn-more-btn">Learn More</button>
    </div>
  );
};

export default BookCard;
