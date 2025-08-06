import React from 'react';
import { useAdminOrders } from '../../Hooks/OrderManagment/useAdminOrders';
import Trash from '../../Assets/Icons/Trash.svg';
import edit from '../../Assets/Icons/edit.svg';
import './orderManagement.css';

const OrderManagement = () => {
  const { orders, loading, error, changeStatus, cancelOrder, fetchOrders } = useAdminOrders();

  const formatDate = (created_at) => {
    const date = new Date(created_at);
    return date.toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric',
    });
  };

  return (
    <div className="orders-container">
      <h1 className="orders-title">Order Management</h1>
      <div className="table-container">
        <table className="orders-table">
          <thead>
            <tr className="table-header">
              <th className="header-cell">Order</th>
              <th className="header-cell">Date</th>
              <th className="header-cell">Order Status</th>
              <th className="header-cell">Total</th>
              <th className="header-cell">Actions</th>
            </tr>
          </thead>
          <tbody>
            {loading ? (
              <tr>
                <td colSpan="5" className="loading-cell">
                  <div className="loading">Loading orders...</div>
                </td>
              </tr>
            ) : error ? (
              <tr>
                <td colSpan="5" className="error-cell">
                  <div className="error-container">
                    <div className="error">Error: {error}</div>
                    <button onClick={fetchOrders} className="retry-btn">Retry</button>
                  </div>
                </td>
              </tr>
            ) : orders.length > 0 ? (
              orders.sort((a, b) => b.id - a.id).map((order) => (
                <tr key={order.id} className="table-row">
                  <td className="table-cell order-id">#{order.id}</td>
                  <td className="table-cell">{formatDate(order.created_at)}</td>
                  <td className={`table-cell status ${order.status.toLowerCase().replace(' ', '-')}`}>
                    {order.status}
                  </td>
                  <td className="table-cell total">${order.total}</td>
                  <td className='table-cell actions-cell'>
                    <div className='button-group'>
                      <button
                        disabled={order.status === "delivered" || order.status === "cancelled"}
                        onClick={() => changeStatus(order.id)}
                        className='edit-btn'>
                        <img src={edit} alt="Edit Icon" className="icon-edit" />
                        {{
                          paid: "Pack",
                          packed: "Ship",
                          shipped: "Deliver"
                        }[order.status]}
                      </button>

                      <button
                        onClick={() => cancelOrder(order.id)}
                        disabled={order.status === "delivered" || order.status === "cancelled"}
                        className='delete-btn'>
                        <img src={Trash} alt="cancel" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="5" className="no-orders-cell">
                  <div className="no-orders">
                    <p>No orders found.</p>
                  </div>
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default OrderManagement;
