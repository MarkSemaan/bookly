import  { useState } from "react";
import Button from "../../Shared/Button/Button";
import Input from "../../Shared/AuthInput/AuthInput";
import useLogin from "../../../Hooks/Auth/useLoginForm";

const LoginForm = () => {
  const { form, handleChange, handleLogin, message } = useLogin();

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
