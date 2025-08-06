import { useState } from "react";
import loginService from "../../Services/authService/loginService";
import { useNavigate } from "react-router-dom";
import { useAuth } from "../../Context/AuthContext";

const useLogin = () => {
  const [form, setForm] = useState({ email: "", password: "" });
  const [message, setMessage] = useState({ type: "", text: "" });
  const navigate = useNavigate();
  const { login } = useAuth();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

const handleLogin = async (e) => {
  e.preventDefault();
  try {
    const response = await loginService(form.email, form.password);
    const payload = response.payload;

    const { token, role } = payload;
    login(token, role);

    setMessage({ type: "success", text: "Login successful" });
    setTimeout(() => setMessage({ type: "", text: "" }), 3000);
    navigate("/");
  } catch (error) {
    setMessage({ type: "error", text: "Login failed" });
    setTimeout(() => setMessage({ type: "", text: "" }), 3000);
    console.error("Login error:", error);
  }
};

  return { form, handleChange, handleLogin, message };
};

export default useLogin;
