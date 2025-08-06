
import Button from "../../Shared/Button/Button";
import Input from "../../Shared/AuthInput/AuthInput";
import useRegister from "../../../Hooks/Auth/useRegisterForm";

const RegisterForm = () => {

  const { form, handleChange, handleSubmit, message, loading } = useRegister();

  return (
    <form className="register-form" onSubmit={handleSubmit}>
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
        <Button text={loading ? "Registering..." : "Register"} disabled={loading} />
      </div>
    </form>
  );
};

export default RegisterForm;
