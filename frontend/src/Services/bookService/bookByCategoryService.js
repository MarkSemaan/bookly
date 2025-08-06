import api from "../axios/useAxios";

export const getBookByCategoryId = async (categoryId) => {
  return await api.get(`/user/books/category/${categoryId}`);
};
