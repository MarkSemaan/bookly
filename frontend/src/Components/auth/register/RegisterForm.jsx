import React, { useState } from "react";
import Button from "../../Shared/Button/Button";
import Input from "../../Shared/AuthInput/AuthInput";
import { useNavigate } from "react-router-dom";
import registerService from "../../../Services/authService/registerService";
import useForm from "../../../Hooks/useForm";

const RegisterForm = () => {
  const [form, handleChange] = useForm({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
  });

  const [message, setMessage] = useState({ type: "", text: "" });
  const navigate = useNavigate();

  const handleRegister = async (e) => {
    e.preventDefault();

    try {
      await registerService(form);
      setMessage({ type: "success", text: "Registration successful!" });
      navigate("/homePage");
    } catch (error) {
      setMessage({ type: "error", text: "Failed to register" });
      console.error(error);
    }
  };

  return (
    <form className="register-form" onSubmit={handleRegister}>
      <h2 className="form-title">Create your account</h2>

      {message.text && (
        <p className={message.type === "error" ? "error-message" : "success-message"}>
          {message.text}
        </p>
      )}

      <div className="name-row firstlast">
        <Input
          name="firstName"
          hint="First Name"
          placeholder="John"
          onChangeListener={handleChange}
          value={form.firstName}
        />
        <Input
          name="lastName"
          hint="Last Name"
          placeholder="Doe"
          onChangeListener={handleChange}
          value={form.lastName}
        />
      </div>

      <div className="Second">
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

      <div className="button-register">
        <Button text="Register" />
      </div>
    </form>
  );
};

export default RegisterForm;
