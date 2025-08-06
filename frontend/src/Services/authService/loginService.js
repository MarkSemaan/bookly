import api from "../axios/useAxios";

const loginService = async (email, password) => {
  const response = await api.post("/guest/login", { email, password });
  return response.data;
};

export default loginService;
