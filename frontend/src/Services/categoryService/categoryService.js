import api from "../axios/useAxios";

export const getCategory = async () => {
  return await api.get("user/categories");
};
