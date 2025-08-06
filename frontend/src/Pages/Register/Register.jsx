 
import Circles from "../../Components/Shared/Circles/Circles";
import RegisterHeader from "../../Components/auth/register/RegisterHeader";
import RegisterCard from "../../Components/auth/register/RegisterForm";
import RegisterAnimations from "../../Components/auth/register/RegsiterAnimation";
import RegisterFooter from "../../Components/auth/register/RegisterFooter";
import "./register.css";

const Register = () => {
  return (
    <div className="register-container-wrapper">
      <RegisterHeader />
      <Circles />
      <div className="register-container">
        <RegisterCard />
        <div className="register-animation">
          <RegisterAnimations />
        </div>
      </div>
      <div className="register-footer">
        <RegisterFooter />
      </div>
    </div>
  );
};

export default Register;
