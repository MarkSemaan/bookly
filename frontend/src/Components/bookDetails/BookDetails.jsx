import React, { useState } from 'react';
import { useParams } from 'react-router-dom';
import useBookDetails from '../../Hooks/useBookDetails';
import useAddToCart from '../../Hooks/useAddToCart';
import "./bookDetails.css";

const BookDetails = () => {
  const { id } = useParams();
  const { book, error, loading } = useBookDetails(id);
  const { handleAddToCart, loading: cartLoading, error: cartError } = useAddToCart();

  const [successMessage, setSuccessMessage] = useState('');

  const handleClick = async () => {
    const result = await handleAddToCart(book.id, 1);
    if (result) {
      setSuccessMessage('✅ Book added to your cart!');
      setTimeout(() => setSuccessMessage(''), 3000);
    } else {
      setSuccessMessage('');
    }
  };

  if (loading) return <p>Loading book details...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className="book-details-container">
      <div className="book-content-wrapper">
        <img src={book.image} alt={book.title} className="book-img" />
        <h1 className="book-titlee">{book.title}</h1>

        <div className="details-box">
          <div className="info-layout">
            <div className="description-container">
              <h2 className="section-title">Description</h2>
              <p className="description">{book.description}</p>

              <div className="info-item-year">
                <p className="info-label-year">Published Year</p>
                <p className="info-value-year">{book.published_year}</p>
              </div>
            </div>

            <div className="side-info-grid">
              <div className="info-item">
                <p className="info-label">Author</p>
                <p className="info-value">{book.author}</p>
              </div>
              <div className="info-item">
                <p className="info-label">Publisher</p>
                <p className="info-value">{book.publisher}</p>
              </div>
              <div className="info-item element">
                <p className="info-label">Price</p>
                <p className="info-value color">${book.price}</p>
              </div>
              <div className="info-item element">
                <p className="info-label">In Stock</p>
                <p className="info-value color">{book.stock}</p>
              </div>
            </div>
          </div>

          <button
            className='add-to-cart'
            onClick={handleClick}
            disabled={cartLoading}
          >
            {cartLoading ? 'Adding...' : 'Add to Cart'}
          </button>

          {successMessage && <p className="success-message">{successMessage}</p>}
          {cartError && <p className="error-message">{cartError}</p>}
        </div>
      </div>
    </div>
  );
};

export default BookDetails;
