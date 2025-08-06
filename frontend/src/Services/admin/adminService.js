import api from '../axios/useAxios'; 

export const fetchDashboardAnalytics = async () => {
  try {
    const response = await api.get('/admin/dashboard');
    return response.data.payload;
  } catch (error) {
    throw error;
  }
}
