import api from "../axios/useAxios";

export const fetchBooksFromApi = () => {
  return api.get("/admin/books");
};

export const deleteBookById = (bookId) => {
  return api.post(`/user/books/delete/${bookId}`);
};

export const createBook = (bookData) => {
  return api.post("/user/books/books", bookData);
};

export const updateBook = (id, data) => {
  return api.put(`/user/books/books/${id}`, data);
};

export const getBookById = (id) => {
  return api.get(`/user/books/book/${id}`);
};
