import api from '../axios/useAxios';

export const getRecommendedBooks = async () => {
  try {
    const response = await api.get('/recommender/get');
    return response.data;
  } catch (error) {
    throw error;
  }
};

