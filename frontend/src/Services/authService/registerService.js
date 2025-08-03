import axios from "axios";

const registerService = async (data) => {
    
  try {
    const response = await axios.post("http://localhost:8000/api/v0.1/guest/register", {
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
      password: data.password,
    });
    return response.data;
  } catch (error) {
    console.error("API error response:", error.response?.data || error.message);
    throw error;
  }
};

export default registerService;
