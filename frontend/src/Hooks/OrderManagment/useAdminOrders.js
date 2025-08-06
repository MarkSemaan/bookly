import { useEffect, useState } from 'react';
import {getAdminOrders, cancelOrder, changeOrderStatus}  from '../../Services/orderService/orderManagmentService';

export const useAdminOrders = () => {
  const [orders, setOrders] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchOrders();
  }, []);

  const handleFetchError = (err) => {
    const msg = err?.response?.data?.message || 'Failed to fetch orders';
    setError(msg);
    setLoading(false);
  };

  const fetchOrders = () => {
    setLoading(true);
    getAdminOrders()
      .then(res => {
        setOrders(res.data.payload || []);
        setLoading(false);
      })
      .catch(handleFetchError);
  };

  const updateOrderState = (updatedOrder) => {
    setOrders(prev =>
      prev.map(order =>
        order.id === updatedOrder.id ? updatedOrder : order
      )
    );
  };

  const handleChangeStatus = (id) => {
    changeOrderStatus(id)
      .then(res => {
        if (res.data?.payload) {
          updateOrderState(res.data.payload);
        }
      })
      .catch(handleFetchError);
  };

  const handleCancelOrder = (id) => {
    cancelOrder(id)
      .then(res => {
        if (res.data?.payload) {
          updateOrderState(res.data.payload);
        }
      })
      .catch(handleFetchError);
  };

  return {
    orders,
    loading,
    error,
    fetchOrders,
    changeStatus: handleChangeStatus,
    cancelOrder: handleCancelOrder,
  };
};
