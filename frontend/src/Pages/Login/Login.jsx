 
import Circles from "../../Components/Shared/Circles/Circles";
import LoginAnimations from "../../Components/auth/login/LoginAnimation";
import LoginCard from "../../Components/auth/login/LoginForm";
import LoginHeader from "../../Components/auth/login/LoginHeader";
import LoginFooter from "../../Components/auth/login/LoginFooter";
import "./login.css";

const Login = () => {
  return (
    <div className="login-container-wrapper">
      <LoginHeader />
      <Circles />
      <div className="login-container">
        <div className="login-animations">
        <LoginAnimations />
        </div>

        <LoginCard />
      </div>
      <div className="login-footer">
      <LoginFooter />
      </div>
    </div>
  );
};

export default Login;
