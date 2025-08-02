import axios from "axios";

const registerService = async (data) => {
  const response = await axios.post("http://127.0.0.1:8000/api/v0.1/guest/register", {
    first_name: data.firstName,
    last_name: data.lastName,
    email: data.email,
    password: data.password,
  });

  return response.data;
};

export default registerService;
