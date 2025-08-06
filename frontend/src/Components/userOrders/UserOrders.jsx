import React from 'react';
import { useUserOrders }  from '../../Hooks/OrderManagment/useUserOrders';
import './userOrders.css';

const UserOrders = () => {
 const { orders, loading, error, fetchOrders } = useUserOrders();
    
  

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
        <div className="orders-container-user">
            <h1 className="orders-title-user">My Orders</h1>
            <div className="table-container-user">
                <table className="orders-table">
                    <thead>
                        <tr className="table-header-user">
                            <th className="header-cell-user">Order</th>
                            <th className="header-cell-user">Date</th>
                            <th className="header-cell-user">Order Status</th>
                            <th className="header-cell-user">Total</th>
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
                                <tr key={order.id} className="table-row-user">
                                    <td className="table-cell-user order-id-user">#{order.id}</td>
                                    <td className="table-cell-user">{formatDate(order.created_at)}</td>
                                    <td className={`table-cell-user status ${order.status.toLowerCase().replace(' ', '-')}`}>
                                        {order.status}
                                    </td>
                                    <td className="table-cell-user total-user">${order.total}</td>
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