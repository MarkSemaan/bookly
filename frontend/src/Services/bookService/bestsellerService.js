import api from "../axios/useAxios";

export const getBestsellers = async () => {
  return await api.get("/user/books/toprated");
};



