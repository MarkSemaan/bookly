import React from "react";
import { Link } from "react-router-dom";
import Circles from "../../Components/Shared/Circles/Circles";
import RegisterHeader from "../../Components/auth/register/RegisterHeader";
import RegisterCard from "../../Components/auth/register/RegisterForm";
import RegisterAnimations from "../../Components/auth/register/RegsiterAnimation";
import RegisterFooter from "../../Components/auth/register/RegisterFooter";
import "./register.css";

const Register = () => {
  return (
    <div className="register-container-wrapper">
      <Circles />

      <RegisterHeader />

      <div className="register-container">
        <RegisterCard />
        <RegisterAnimations />
      </div>

      <RegisterFooter />
    </div>
  );
};

export default Register;
