import React from 'react';
import './cart.css';
import trash from '../../../src/Assets/Icons/delete.svg';
import useCartHandlers from '../../Hooks/useCartHandlers';



const Cart = () => {
const {
  cart,
  total,
  loading,
  error,
  deleting,
  cartLoading,
  isLoading,
  handleCheckout,
  handleIncrease,
  handleQuantityChange,
  handleRemove
} = useCartHandlers();

  if (loading) return <p>Loading cart...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className="cart-container">
      <h2 className="cart-title">Cart</h2>
      <hr className="cart-line" />

      <div className="cart-items-list">
        {cart.map(item => (
          <div className="cart-item-box" key={item.id}>
            <img
              src={item.book?.image || '/default-book.png'}
              alt={item.book?.title}
              className="book-imagee"
            />

            <div className="book-info">
              <p className="book-title-cart">{item.book?.title}</p>
              <p className="book-cart-price">${item.book?.price}</p>
            </div>

            <div className="quantity-controls">
              <button
                onClick={() => handleQuantityChange(item)}
                disabled={cartLoading}
              >
                -
              </button>
              <span>{item.quantity}</span>
              <button
                onClick={() => handleIncrease(item)}
                disabled={cartLoading}
              >
                +
              </button>
            </div>

            <button
              className="remove-btn"
              onClick={() => handleRemove(item.id)}
              disabled={deleting}
            >
              <img src={trash} className="trash" alt="Remove" />
            </button>
          </div>
        ))}
      </div>


      {cart.length > 0 && (
        <>
          <div className="cart-total-box">
            <hr className="cart-line" />
            <p className="cart-total-text">
              Total Amount: <span className="cart-total-price">${total}</span>
            </p>
          </div>

          <div className="checkout-btn-wrapper">
            <button
              className="checkout-btn"
              onClick={handleCheckout}
              disabled={isLoading}
            >
              {isLoading ? "Processing..." : "Checkout"}
            </button>
          </div>
        </>
      )}
    </div>
  );
};

export default Cart;
