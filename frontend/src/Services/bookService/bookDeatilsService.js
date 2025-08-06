import api from "../axios/useAxios";

export const getBookById = async (id) => {
  return await api.get(`/user/books/book/${id}`);
};
