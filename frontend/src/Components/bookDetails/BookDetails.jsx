import React from 'react';
import { useParams } from 'react-router-dom';
import useBookDetails from '../../Hooks/BookDeatils/useBookDetails';
import useCartHandlerForBookDetails from '../../Hooks/BookDeatils/useCartHandlerForBookDetails';
import "./bookDetails.css";

const BookDetails = () => {
  
  const backendBaseUrl = "http://127.0.0.1:8000/";
  const { id } = useParams();
  const { book, error, loading } = useBookDetails(id);
  const { handleClick, successMessage, cartLoading, cartError } = useCartHandlerForBookDetails(book?.id);

  if (loading) return <p>Loading book details...</p>;
  if (error) return <p>{error}</p>;


  return (
    <div className="book-details-container">
      <div className="book-content-wrapper">
        <img
          src={book.image ? `${backendBaseUrl}${book.image}` : '/default-book.png'}
          className="book-img"
        />
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
  disabled={cartLoading || book.stock < 1}  
>
  {book.stock < 1 ? 'Out of Stock' : (cartLoading ? 'Adding...' : 'Add to Cart')}
</button>

          {successMessage && (
            <div className="message-box">
              {successMessage}
            </div>
          )}

          {cartError && <p style={{ color: 'red' }}>{cartError}</p>}
        </div>
      </div>
    </div>
  );
};

export default BookDetails;
