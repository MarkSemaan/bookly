import React, { useState } from "react";
import Button from "../../Shared/Button/Button";
import Input from "../../Shared/AuthInput/AuthInput";
import { useNavigate } from "react-router-dom";
import authService from "../../../Services/authService/loginService";
import useLoginForm from "../../../Hooks/useForm";

const LoginForm = () => {

  const [form, handleChange] = useLoginForm({ email: "", password: "" });
  const [message, setMessage] = useState({ type: "", text: "" });

  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    try {
      const token = await authService(form.email, form.password);
      localStorage.setItem("token", token);
      setMessage({ type: "success", text: "Login successful" });
      navigate("/");
    } catch (error) {
      setMessage({ type: "error", text: "Login failed" });
      console.error("Login error:", error);
    }
  };

  return (
    <form className="login-form" onSubmit={handleLogin}>
      <h2 className="form-title">Login</h2>

      {message.text && (
        <p className={message.type === "error" ? "error-message" : "success-message"}>
          {message.text}
        </p>
      )}

      <div className="input-wrapper">
        <Input
          name="email"
          hint="Email"
          placeholder="john@example.com"
          onChangeListener={handleChange}
          value={form.email}
        />
        <Input
          type="password"
          name="password"
          hint="Password"
          placeholder="Enter your password"
          onChangeListener={handleChange}
          value={form.password}
        />
      </div>

      <Button text="Login" />
    </form>
  );
};

export default LoginForm;
