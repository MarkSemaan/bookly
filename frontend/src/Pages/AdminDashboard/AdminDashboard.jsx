import { React, useState, useEffect } from 'react';
import axios from 'axios';

import BooksCard from '../../Components/adminDashboard/booksCard/BooksCard';
import DashboardCard from '../../Components/adminDashboard/dashboardCard/DashboardCard';
import OrdersCard from '../../Components/adminDashboard/ordersCard/OrdersCard';
import SalesGraph from '../../Components/adminDashboard/salesGraph/SalesGraph';

import './adminDashboard.css';

const AdminDashboard = () => {
  const [analytics, setAnalytics] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  const base_url = 'http://127.0.0.1:8000/api/v0.1';
  const fetch_url = '/admin/dashboard';

  const fetchAnalytics = () => {
    const token = localStorage.getItem('token');
    setLoading(true);
    const fetched_analytics = axios.get(base_url + fetch_url, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    }).then((res) => {
      let fetched_analytics = res.data.payload;
      console.log(fetched_analytics);
      setAnalytics(fetched_analytics);
      setLoading(false);
    }).catch(error => handleFetchError(error));
  }

  useEffect(() => {
    fetchAnalytics();
  }, []);

  const handleFetchError = (error) => {
    if (error.response && error.response.data) {
      console.log('API Error:', error.response.data);
      setError(error.response.data.message || 'failed to fetch analytics');
    } else {
      console.error('Error:', error);
      setError('Error occurred');
    }
    setLoading(false);
  };

  return (
    <div className="admin-dashboard">
      <h1 className="dashboard-title">Dashboard</h1>

      <div className="dashboard-grid">
        <div className="upper-row">
          <div className="stats-box">
            <div className="row-1">
              <DashboardCard title="Total Sales" value={`$${analytics.sales}`}
                isSmall />
              <DashboardCard title="Books In Stock" value={analytics.stock} isSmall />
            </div>
            <div className="row-2">
              <DashboardCard title="Today's Revenue" value={`$${analytics.revenue}`} isSmall />
              <DashboardCard title="Customers" value={analytics.customers} isSmall />
            </div>
          </div>

          <div className="graph-section">
            <SalesGraph title="Sales Graph" data={analytics.graph}/>
          </div>
        </div>
        <div className="second-row">
          <div className="orders-section">
            <OrdersCard title="Orders" orderStats={analytics.orders} />
          </div>
          <div className="books-section">
            <BooksCard
              title="Top Selling Books"
              books={analytics.top_stock}
              showSales={true}
            />
          </div>
        </div>

        <div className="bottom-row">
          <div className="low-stock-section">
            <BooksCard title="Low Stock" books={analytics.low_stock} />
          </div>
          <div className="notifications-section">
            <DashboardCard notifications={analytics.notifications} />
          </div>
        </div>

      </div>
    </div >
  );
};

export default AdminDashboard;