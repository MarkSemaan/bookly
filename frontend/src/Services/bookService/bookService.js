// src/Services/bookService.js
import api from "../axios/useAxios";

export const createBook = async (bookData) => {
  return api.post("/user/books/books", bookData);
};
