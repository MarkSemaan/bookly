import React from 'react';
import './ordersCard.css';

const OrdersCard = ({ title, orderStats }) => {
  return (
    <div className="orders-card">
      <h3>{title || 'Orders'}</h3>
      <div className="orders-grid">
        <div className="order-stat-up">
          <span className="stat-label">Pending</span>
          <span className="stat-value">{orderStats?.pending || 0}</span>
        </div>
        <div className="order-stat-up">
          <span className="stat-label">Paid</span>
          <span className="stat-value">{orderStats?.paid || 0}</span>
        </div>
        <div className="order-stat-up">
          <span className="stat-label">Packed</span>
          <span className="stat-value">{orderStats?.packed || 0}</span>
        </div>
      </div>
      <div className="orders-additional">
        <div className="order-stat">
          <span className="stat-label">Shipped</span>
          <span className="stat-value">{orderStats?.shipped || 0}</span>
        </div>
        <div className="order-stat">
          <span className="stat-label">Cancelled</span>
          <span className="stat-value">{orderStats?.cancelled || 0}</span>
        </div>
        <div className="order-stat">
          <span className="stat-label">Orders Per Hour</span>
          <span className="stat-value">{orderStats?.ordersPerHour || 0}</span>
        </div>
      </div>
    </div>
  );
};

export default OrdersCard;