import axios from "axios";

const loginService = async (email, password) => {
  const response = await axios.post("http://127.0.0.1:8000/api/v0.1/guest/login", {
    email,
    password,
  });

  return response.data.payload.token;
};

export default loginService;
