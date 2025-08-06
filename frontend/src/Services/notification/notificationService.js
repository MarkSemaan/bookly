import api from '../axios/useAxios';

export const fetchAllNotifications = async () => {
  const response = await api.get('/notifications/notifications');
 return response.data.payload;
};
