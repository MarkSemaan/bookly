import api from "../axios/useAxios";

const registerService = async (data) => {
    const response = await api.post("/guest/register", {
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
      password: data.password,
    });

};

export default registerService;
