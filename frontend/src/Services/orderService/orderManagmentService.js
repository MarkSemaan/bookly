import api from "../axios/useAxios";

export const getUserOrders = () => api.get('/orders/users');

export const getAdminOrders = () => api.get('/admin/orders');

export const cancelOrder = (orderId) => api.post(`/orders/cancel/${orderId}`);

export const changeOrderStatus = (orderId) => api.post(`/admin/orders/move_status/${orderId}`);
