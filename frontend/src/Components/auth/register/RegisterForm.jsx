import { useState } from "react";
import Button from "../../Shared/Button/Button";
import Input from "../../Shared/AuthInput/AuthInput";
import { useNavigate } from "react-router-dom";
import registerService from "../../../Services/authService/registerService";
import useForm from "../../../Hooks/useForm";

const RegisterForm = () => {
  const [form, handleChange] = useForm({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
  });

  const [message, setMessage] = useState({ type: "", text: "" });
  const navigate = useNavigate();
  const handleRegister = async (e) => {
  e.preventDefault();
  console.log("Form state at submission:", form);

  try {
    const data = await registerService(form);
    localStorage.setItem("token", data); 
    setMessage({ type: "success", text: "Registration successful!" });


    setTimeout(() => {
      navigate("/homePage"); 
    }, 500); 
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
          name="first_name"
          hint="First Name"
          placeholder="John"
          onChangeListener={handleChange}
          value={form.first_name}
        />
        <Input
          name="last_name"
          hint="Last Name"
          placeholder="Doe"
          onChangeListener={handleChange}
          value={form.last_name}
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
