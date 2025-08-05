import React from 'react';
import './dashboardCard.css';

const DashboardCard = ({ title, value, isSmall, notifications }) => {
    if (notifications) {
        return (
            <div className="dashboard-card notifications-card">
                <h3>Notifications</h3>
                <div className="notifications-list">
                    {notifications.map((notification, index) => (
                        <div key={index} className="notification-item">
                            <span className="notification-icon">⚠</span>
                            <span className="notification-text">{notification.message}</span>
                        </div>
                    ))}
                </div>
            </div>
        );
    }

    return (
        <div className={`dashboard-card ${isSmall ? 'small-card' : ''}`}>
            <h3>{title}</h3>
            <div className="card-value">{value}</div>
        </div>
    );
};

export default DashboardCard;