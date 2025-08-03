import { React, useState, useEffect } from 'react';
import axios from 'axios';
import './orderManagement.css';
import Trash from '../../Assets/Icons/Trash.svg';

const OrderManagement = () => {
    const [orders, setOrders] = useState([]);
    const [statusChange, setStatusChange] = useState(false);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);
    const base_url = 'http://127.0.0.1:8000/api/v0.1';
    const fetch_url = '/admin/orders';
    const cancel_url = '/orders/cancel/';
    const change_status_url = '/admin/orders/move_status/';

    useEffect(() => {
        fetchOrders();
    }, []);

    useEffect(() => {
        fetchOrders();
    }, [statusChange]);

    const handleFetchError = (error) => {
        if (error.response && error.response.data) {
            console.log('API Error:', error.response.data);
            setError(error.response.data.message || 'failed to fetch orders');
        } else {
            console.error('Error:', error);
            setError('Error occurred');
        }
        setLoading(false);
    };

    const fetchOrders = () => {
        const token = localStorage.getItem('token');
        setLoading(true);
        const user_orders = axios.get(base_url + fetch_url, {
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
    const changeStatus = (order_id) => {
        const token = localStorage.getItem('token');
        const user_orders = axios.post(`${base_url}${change_status_url}${order_id}`, {}, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        }).then((res) => {
            let order = res.data.payload;
            console.log(order);
        }).catch(error => handleFetchError(error));
        if (statusChange)
            setStatusChange(false);
        else
            setStatusChange(true);
    };
    const cancelOrder = (order_id) => {
        const token = localStorage.getItem('token');
        const user_orders = axios.post(`${base_url}${cancel_url}${order_id}`, {}, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        }).then((res) => {
            let order = res.data.payload;
            console.log(order);
        }).catch(error => handleFetchError(error));
        if (statusChange)
            setStatusChange(false);
        else
            setStatusChange(true);
    };
    return (
        <div className="orders-container">
            <h1 className="orders-title">OrderManagement</h1>
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
                                    <td className='table-cell actions-cell'>
                                        <div className='button-grp'>
                                            <button disabled={order.status === "delivered" || order.status === "cancelled"}
                                                onClick={() => changeStatus(order.id)} className='edit-btn'>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="m18.5 2.5 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                {{
                                                    paid: "Mark as Packed",
                                                    packed: "Mark as Shipped",
                                                    shipped: "Mark as Delivered"
                                                }[order.status]}
                                            </button>
                                            <button onClick={() => cancelOrder(order.id)} disabled={order.status === "delivered" || order.status === "cancelled"} 
                                            className='delete-btn'>
                                                <img src={Trash} alt="cancel" />
                                            </button>
                                        </div>
                                    </td>
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

export default OrderManagement;