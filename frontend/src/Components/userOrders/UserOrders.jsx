import { React, useState, useEffect } from 'react';
import axios from 'axios';
import './userOrders.css';

const UserOrders = () => {
    const [orders, setOrders] = useState([]);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);
    
    const base_url = 'http://127.0.0.1:8000/api/v0.1';
    const url = '/orders/users';

    useEffect(() => {
        fetchOrders();
    }, []);

    const handleFetchError = (error) => {
        if (error.response && error.response.data) {
            console.log('API Error:', error.response.data);
            setError(error.response.data.message || 'failed to fetch capsules');
        } else {
            console.error('Error:', error);
            setError('Error occurred');
        }
        setLoading(false);
    };

    const fetchOrders = () => {
        const token = localStorage.getItem('token');
        setLoading(true);
        const user_orders = axios.get(base_url + url, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        }).then((res) => {
            let fetchedOrders = res.data.payload;
            setOrders(fetchedOrders);
            setLoading(false);
        }).catch(error => handleFetchError(error));
    }

    const formatDate = (created_at) => {
        const formatDateTime = (dateString) => {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        };
        const created_date = formatDateTime(created_at);
        return created_date;
    };

    return (
        <div className="orders-container">
            <h1 className="orders-title">My Orders</h1>
            <div className="table-container">
                <table className="orders-table">
                    <thead>
                        <tr className="table-header">
                            <th className="header-cell">Order</th>
                            <th className="header-cell">Date</th>
                            <th className="header-cell">Order Status</th>
                            <th className="header-cell">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {loading ? (
                            <tr>
                                <td colSpan="4" className="loading-cell">
                                    <div className="loading">Loading orders...</div>
                                </td>
                            </tr>
                        ) : error ? (
                            <tr>
                                <td colSpan="4" className="error-cell">
                                    <div className="error-container">
                                        <div className="error">Error: {error}</div>
                                        <button onClick={fetchOrders} className="retry-btn">
                                            Retry
                                        </button>
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
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="4" className="no-orders-cell">
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
}

export default UserOrders;