import BooksCard from '../../Components/adminDashboard/booksCard/BooksCard';
import DashboardCard from '../../Components/adminDashboard/notification/Notification';
import OrdersCard from '../../Components/adminDashboard/ordersCard/OrdersCard';
import SalesGraph from '../../Components/adminDashboard/salesGraph/SalesGraph';
import useDashboardAnalytics from '../../Hooks/Admin/useDashboardAnalytics';

import './adminDashboard.css';

const AdminDashboard = () => {
  const { analytics, loading, error } = useDashboardAnalytics();

  if (loading) return <p>Loading...</p>;
  if (error) return <p className="error-msg">{error}</p>;

  const topSellingBooks = analytics.top_stock.slice(0, 3);
  const lowStockBooks = analytics.low_stock.slice(0, 3);  

  return (
    <div className="admin-dashboard">
      <h1 className="dashboard-title">Dashboard</h1>

      <div className="dashboard-grid">
        <div className="upper-row">
          <div className="stats-box">
            <div className="row-1">
              <DashboardCard title="Total Sales" value={`$${analytics.sales}`} isSmall />
              <DashboardCard title="Books In Stock" value={analytics.stock} isSmall />
            </div>
            <div className="row-2">
              <DashboardCard title="Today's Revenue" value={`$${analytics.revenue}`} isSmall />
              <DashboardCard title="Customers" value={analytics.customers} isSmall />
            </div>
          </div>

          <div className="books-section">
            <BooksCard
              title="Top Selling Books"
              books={topSellingBooks}
              showSales={true}
            />
          </div>
        </div>

        <div className="second-row">
          <div className="orders-section">
            <OrdersCard title="Orders" orderStats={analytics.orders} />
          </div>
          <div className="low-stock-section">
            <BooksCard
              title="Low Stock"
              books={lowStockBooks}
            />
          </div>
        </div>

        <div className="bottom-row">
          <div className="graph-section">
            <SalesGraph title="Sales Graph" data={analytics.graph} />
          </div>
        </div>
      </div>
    </div>
  );
};

export default AdminDashboard;
