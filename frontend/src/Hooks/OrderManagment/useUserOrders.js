import { useEffect, useState } from 'react';
import {getUserOrders} from '../../Services/orderService/orderManagmentService';


export const useUserOrders = () => {
  const [orders, setOrders] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  const fetchOrders = () => {
    setLoading(true);
    getUserOrders()
      .then(res => {
        setOrders(res.data.payload || []);
        setLoading(false);
      })
      .catch(err => {
        const msg = err?.response?.data?.message || 'Failed to fetch orders';
        setError(msg);
        setLoading(false);
      });
  };

  useEffect(() => {
    fetchOrders();
  }, []);

  return { orders, loading, error, fetchOrders };
};
