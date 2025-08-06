import React, { useState } from 'react';
import notification from "../../Assets/Icons/notfication.svg";
import useNotifications from '../../Hooks/Notification/useNotifications';
import './notificationBox.css';

const NotificationBox = () => {
  const [isOpen, setIsOpen] = useState(false);
  const { notifications, loading } = useNotifications();

  const toggleDropdown = () => setIsOpen(!isOpen);
  const hasUnread = notifications.some(notif => !notif.read);

  return (
    <div className="notification-wrapper">
      <div className="notification-icon" onClick={toggleDropdown}>
      <img src={notification}/>
        {hasUnread && <span className="notification-dot" />}
      </div>

      {isOpen && (
        <div className="notification-dropdown">
          <h4 className='ntitle'>Notifications</h4>
          {loading ? (
            <p className="loading">Loading...</p>
          ) : notifications.length === 0 ? (
            <p className="empty">No notifications yet</p>
          ) : (
            <ul className="notification-list">
              {notifications.map((notif) => {
                const { message, status, order_id, items, total } = notif.data;
                return (
                  <li key={notif.id} className="notification-item">
                    <p className="notif-title">
                      <strong>Order #{order_id}</strong> is <span className={`statuss ${status}`}>{status}</span>
                    </p>
                    <p className="notif-message">{message}</p>
                    {items?.map((item, idx) => (
                      <div key={idx} className="item-details">
                        <span>{item.title}</span>
                        <span>Qty: {item.quantity}</span>
                        <span>${item.price}</span>
                      </div>
                    ))}
                    <p className="notif-total"><strong>Total:</strong> ${total}</p>
                    <small className="notif-date">{new Date(notif.created_at).toLocaleString()}</small>
                  </li>
                );
              })}
            </ul>
          )}
        </div>
      )}
    </div>
  );
};

export default NotificationBox;
