import { useEffect, useState } from 'react';
import { fetchDashboardAnalytics } from '../../Services/admin/adminService';

const useDashboardAnalytics = () => {
  const [analytics, setAnalytics] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const getAnalytics = async () => {
      try {
        const data = await fetchDashboardAnalytics();
        setAnalytics(data);
      } catch (err) {
        console.error('Fetch error:', err);
        setError(err?.response?.data?.message || 'Failed to fetch analytics');
      } finally {
        setLoading(false);
      }
    };

    getAnalytics();
  }, []);

  return { analytics, loading, error };
};

export default useDashboardAnalytics;
