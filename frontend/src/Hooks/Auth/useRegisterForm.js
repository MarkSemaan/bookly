import { useState, useRef, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import registerService from "../../Services/authService/registerService";
import { useAuth } from "../../Context/AuthContext";

const useRegister = (initialForm = {
  first_name: "",
  last_name: "",
  email: "",
  password: ""
}) => {
  const [form, setForm] = useState(initialForm);
  const [message, setMessage] = useState({ type: "", text: "" });
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();
  const timeoutRef = useRef(null);
  const { login } = useAuth();


  useEffect(() => {
    return () => clearTimeout(timeoutRef.current);
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const token = await registerService(form);
      login(token); 
      setMessage({ type: "success", text: "Registration successful!" });

     
      timeoutRef.current = setTimeout(() => {
        setMessage({ type: "", text: "" });
        navigate("/");
      }, 700);
    } catch (error) {
      setMessage({ type: "error", text: error?.response?.data?.message || "Failed to register" });
      console.error("Register error:", error);
      timeoutRef.current = setTimeout(() => setMessage({ type: "", text: "" }), 3000);
    } finally {
      setLoading(false);
    }
  };

  const resetForm = () => setForm(initialForm);

  return {
    form,
    handleChange,
    handleSubmit,
    message,
    loading,
    resetForm
  };
};

export default useRegister;
