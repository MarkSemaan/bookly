import axios from 'axios';

const BaseURL = "http://localhost:8000";
const API_BASE_URL = `${BaseURL}/api/v0.1`;

const axiosInstance = axios.create({
  baseURL: API_BASE_URL,
});

axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);


export const registerUser = (userData) => axiosInstance.post(`/guest/register`, userData);
export const loginUser = (userData) => axiosInstance.post(`/guest/login`, userData);


export const searchBooks = (payload) => axiosInstance.get(`/user/books/book`, { params: payload });
export const getBooks = (id = '') => axiosInstance.get(`/user/books/book/${id}`);
export const getBooksByCategory = (categoryId) => axiosInstance.get(`/user/books/category/${categoryId}`);
export const addOrUpdateBook = (bookData, id = '') =>
    id ? axiosInstance.put(`/user/books/books/${id}`, bookData) : axiosInstance.post(`/user/books/books`, bookData);
export const deleteBook = (bookId) => axiosInstance.delete(`/user/books/${bookId}`);
export const getTopRatedBooks = () => axiosInstance.get(`/user/books/toprated`);


export const getCategories = () => axiosInstance.get(`/user/categories`);

export const saveSearch = (payload) => axiosInstance.post(`/user/recommender/save_search`, payload);
export const saveBookView = (payload) => axiosInstance.post(`/user/recommender/save_view`, payload);
export const getRecommended = () => axiosInstance.get(`/user/recommender/get`);

export const getCartItems = (id = '') => axiosInstance.get(`/cartitems/${id}`);
export const getUserCartItems = () => axiosInstance.get(`/cartitems/user/cart`);
export const getCartTotal = () => axiosInstance.get(`/cartitems/total/cart`);
export const addOrUpdateCartItem = (data) => axiosInstance.post(`/cartitems/cart`, data);
export const decreaseCartItem = (data) => axiosInstance.post(`/cartitems/decrease`, data);
export const deleteCartItem = (id) => axiosInstance.delete(`/cartitems/delete/${id}`);

export const getOrders = (id = '') => axiosInstance.get(`/orders/orders/${id}`);
export const getUserOrders = (userId) => axiosInstance.get(`/orders/users/${userId}`);
export const createOrder = (data) => axiosInstance.post(`/orders`, data);
export const createOrderFromCart = (data) => axiosInstance.post(`/orders/from-cart`, data);
export const cancelOrder = (orderId) => axiosInstance.post(`/orders/${orderId}/cancel`);
export const deleteOrder = (orderId) => axiosInstance.delete(`/orders/${orderId}`);
